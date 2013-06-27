<?php

class Controller_Achat_Order extends Controller_Frontend
{
    public function action_view()
	{
        if(Fuel::$env == Fuel::DEVELOPMENT) 
            $this->template->js_supp = 'achat/order.js';
        else if(Fuel::$env == Fuel::TEST) 
            $this->template->js_supp = 'achat/order.js';
        else $this->template->js_supp = 'achat/order.min.js';
        $this->template->css_supp = 'order.css';
        
        // Verification of checked order
        $recent = Model_Achat_Order::getRecentCheckoutOrder();
        
        if(!empty($recent['token'])) {
            if($recent['order']->state == "STARTPAY") { 
                $recent['order']->cancelPayment($recent['token']);
                
                // Reset current cart
                $current_cart = $recent['order']->getCart();
                if($current_cart) {
                    // Set user in cart if user not existed in cart
                    if( $this->current_user )
                        $current_cart->setUser($this->current_user->id);
                    $this->cart = $current_cart;
                }
            }
        }

	    if(!empty($this->cart)) {
	        $products = $this->cart->getProducts();
	        $currency = $this->cart->getCurrency();
	        $total = $this->cart->addition();
	        $ht = round($total * (1 - $this->cart->tax_rate/100), 2);
	        $tax = $total - $ht;
	        
	        if(count($products) != 0) {
    	        
    	        if($this->current_user) {
        	        // Order the cart
        	        $order = Model_Achat_Order::orderCart($this->cart);
        	        
        	        if(!$order) {
        	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
        	            $this->template->content = View::forge('achat/order/empty');
        	        }
        	        else {
        	            $data = array(
        	                'order' => $order,
        	                'cart' => $this->cart,
        	                'total' => $total,
        	                'ht' => $ht,
        	                'tva' => number_format($this->cart->tax_rate, 2, '.', ''),
        	                'tax' => $tax,
        	                'products' => $products,
        	                'currency' => $currency,
        	                'payzenCheckoutForm' => Payzen::getCheckoutForm($order)
        	            );
        	            
        	            $user_address = Model_User_Address::query()->where('user_id', $this->current_user->id)->get_one();
        	            View::set_global('user_address', $user_address);
        	            
        	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
        	        	$this->template->content = View::forge('achat/order/view', $data);
        	        }
    	        }
    	        // Show user login
    	        else {
    	            $data = array(
    	                'cart' => $this->cart,
    	                'total' => $total,
    	                'ht' => $ht,
    	                'tva' => number_format($this->cart->tax_rate, 2, '.', ''),
    	                'tax' => $tax,
    	                'products' => $products,
    	                'currency' => $currency,
    	            );
    	            
    	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
    	            $this->template->content = View::forge('achat/order/view', $data);
    	        }
	        }
	        // No product
	        else {
	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	            $this->template->content = View::forge('achat/order/empty');
	        }
	    }
	    // No cart
	    else {
	        $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	        $this->template->content = View::forge('achat/order/empty');
	    }
	}
	
	public function action_paypalCheckout()
	{
	    $order = Model_Achat_Order::getCurrentOrder();
	    
	    if(!empty($order)) {
    	    try {
    	        $result = $order->checkoutWith(new Paypal());
    	        
    	        if(!$result['success']) {
    	            if(isset($result['errorMessage'])) 
    	                Session::set_flash('error', $result['errorMessage']);
    	            else Session::set_flash('error', "Erreur inconnu");
    	        }
    	    }
    	    catch (FuelException $e) {
    	        Session::set_flash('error', 'Erreur: ' . $e->getMessage());
    	    }
        }
        else {
            Session::set_flash('error', 'Erreur: Il n\'y a pas de commande valide.');
        }
    
        return Response::forge(View::forge('achat/order/cancel'));
	}
	
	public function action_paypalConfirm()
	{
	    $token = $_REQUEST['token'];
	    
	    if(!empty($token)) {
    	    // Get order
    	    $order = Model_Achat_Order::getCheckoutOrder($token);
    	    
    	    if(!empty($order)) {
    	        try {
    	            $payment = Paypal::getByToken($token);
    	            $result = $payment->confirmPayment($order, $token, array('PayerID' => $_REQUEST['PayerID']));
    	            
    	            if($result['success']) {
    	                $data = $result['confirmData'];
    	                $user_address = Model_User_Address::query()->where('user_id', $data['user_id'])->get_one();
    	            
    	                $datamail = array(
    	                    'ref' => $order->reference,
    	                    'total' => $data['total'],
    	                    'ht' => $data['ht'],
    	                    'tva' => $data['tva'],
    	                    'tax' => $data['tax'],
    	                    'products' => $data['products'],
    	                    'currency' => $data['currency'],
    	                    'addr' => $user_address,
    	                    'cmdtime' => time()
    	                );
    	                // Send welcome mail
    	                Controller_Base::sendHtmlMail(
    	                    'no-reply@encrenomade.com', 
    	                    'Season13.com', 
    	                    $user_address->email, 
    	                    'Facture Season13.com', 
    	                    'mail/facture', 
    	                    $datamail
    	                );
    	            
    	                return Response::forge(View::forge('achat/order/confirm', $data));
    	            }
    	            else {
    	                if(isset($result['errorMessage'])) 
    	                    Session::set_flash('error', $result['errorMessage']);
    	                else Session::set_flash('error', "Erreur inconnu");
    	            }
    	        }
    	        catch (Exception $e) {
    	            Session::set_flash('error', 'Erreur: ' . $e->getMessage());
    	        }
        	}
    	}
    	
    	return Response::forge(View::forge('achat/order/cancel'));
	}
	
	
	public function action_payzenCheck() {
	    // Collect informations
	    $transid = Input::param('vads_trans_id');
	    if( empty($transid) )
	        return new Response(Format::forge(array('success' => false))->to_json(), 200);
	        
	    // Reconstruction of order reference
	    if(Input::param('vads_order_id')) {
	        $order_ref = Input::param('vads_order_id');
	    }
	    else {
    	    // Date
    	    $date = Input::param('vads_trans_date') ? substr(Input::param('vads_trans_date'), 2, 6) : Date::time()->format("%y%m%d");
    	    $order_ref = $date.substr($transid, 2);
	    }
	
	    // Array for payzen check model
	    $arr = array(
	        "order_ref" => $order_ref,
	        "vads_result" => Input::param('vads_result') ?: "",
	        "vads_trans_status" => Input::param('vads_trans_status') ?: "",
	        "vads_auth_result" => Input::param('vads_auth_result') ?: "",
	        "vads_auth_mode" => Input::param('vads_auth_mode') ?: "",
	        "vads_trans_id" => $transid,
	        "signature" => Input::param('signature') ?: "",
	        "params" => Format::forge(Input::all())->to_json()
	    );
	    
	    $record = Model_Achat_Payzencheck::forge($arr);
	    if($record) $record->save();
	    
	    $order = Model_Achat_Order::find_by_reference($order_ref);
	    $result = array('success' => true, 'state' => "NOCMD");
	    
	    // Amount Paid
	    $amt_paid = Input::param('vads_effective_amount') ? intval(Input::param('vads_effective_amount'))/100 : $order->getCart()->addition();
	    
	    // Success
	    if( $arr['vads_result'] == "00" && $arr['vads_trans_status'] == "AUTHORISED" ) {
	        if($order) {
	            // Check out order
	            $order->getCart()->checkout();
	            // Directly confirm order
	            $order->finalize('payzen', $arr, $amt_paid);
	            
	            $data = Payment::extractOrder($order);
                $data['return_page'] = true;
                $user_address = Model_User_Address::query()->where('user_id', $data['user_id'])->get_one();
            
                $datamail = array(
                    'ref' => $order->reference,
                    'total' => $data['total'],
                    'ht' => $data['ht'],
                    'tva' => $data['tva'],
                    'tax' => $data['tax'],
                    'products' => $data['products'],
                    'currency' => $data['currency'],
                    'addr' => $user_address,
                    'cmdtime' => time()
                );
                // Send welcome mail
                Controller_Base::sendHtmlMail(
                    'no-reply@encrenomade.com', 
                    'Season13.com', 
                    $user_address->email, 
                    'Facture Season13.com', 
                    'mail/facture', 
                    $datamail
                );
	            
	            $result['state'] = "FINALIZE";
	        }
	    }
	    else if( !empty($arr['vads_result']) && !empty($arr['vads_trans_status']) ) {
	        if($order) {
	            // Check out order
	            $order->checkout($transid);
	            // Failed
	            $order->payfailed('payzen', $arr);
	            
	            $result['state'] = "FAIL";
	        }
	    }
	    
	    return new Response(Format::forge($result)->to_json(), 200);
	}
	
	public function action_payzenReturn() {
	    $transid = Input::get('vads_trans_id');
	    if( empty($transid) ) {
	        return Response::forge(View::forge('achat/order/cancel', array('return_page' => true)));
	    }
	    $order_ref = Date::time()->format("%y%m%d").substr($transid, 2);
	    
	    $arr = array(
	        "vads_result" => Input::get('vads_result') ?: "",
	        "vads_trans_status" => Input::get('vads_trans_status') ?: "",
	        "vads_auth_result" => Input::get('vads_auth_result') ?: "",
	        "vads_auth_mode" => Input::get('vads_auth_mode') ?: "",
	        "vads_trans_id" => $transid,
	        "signature" => Input::get('signature') ?: ""
	    );
	    
	    $order = Model_Achat_Order::find_by_reference($order_ref);
	    
	    // Success
	    if( $arr['vads_result'] == "00" && $arr['vads_trans_status'] == "AUTHORISED" ) {
	        if($order) {
	            $data = Payment::extractOrder($order);
	            $data['return_page'] = true;
                
                return Response::forge(View::forge('achat/order/confirm', $data));
	        }
	        else {
	            Session::set_flash('error', "Si votre carte bancaire a été débité, vous pouvez nous contacter au contact@encrenomade.com");
	            return Response::forge(View::forge('achat/order/cancel', array('return_page' => true)));
	        }
	    }
	    else {
	        return Response::forge(View::forge('achat/order/cancel', array('return_page' => true)));
	    }
	}
	
	public function action_freeCheckout() {
	    $order = Model_Achat_Order::getCurrentOrder();
	    
	    // Verify order
	    if($order) {
	        $token = Str::random('alnum', 16);
	        $cart = $order->getCart();
	        $products = $cart->getProducts();
	        $total = $cart->addition();
	        
	        // Free order check
	        if(count($products) > 0 && $total == 0) {
                // Check out order
                $order->checkout($token);
                // Directly confirm order
                $order->finalize('free', array(), 0);
                
                // Prepare view data
                $ht = round($total * (1 - $cart->tax_rate/100), 2);
                $tax = $total - $ht;
            
                $data = array(
                    'total' => $total,
                    'ht' => $ht,
                    'tax' => $tax,
                    'tva' => number_format($cart->tax_rate, 2, '.', '')."%",
                    'products' => $products,
                    'currency' => $cart->getCurrency(),
                    'return_page' => true,
                );
                
                $user_address = Model_User_Address::query()->where('user_id', $order->user_id)->get_one();
                
                $datamail = array(
                    'ref' => $order->reference,
                    'total' => $total,
                    'ht' => $ht,
                    'tva' => $data['tva'],
                    'tax' => $tax,
                    'products' => $products,
                    'currency' => $data['currency'],
                    'addr' => $user_address,
                    'cmdtime' => time()
                );
                // Send welcome mail
                Controller_Base::sendHtmlMail(
                    'no-reply@encrenomade.com', 
                    'Season13.com', 
                    $user_address->email, 
                    'Facture Season13.com', 
                    'mail/facture', 
                    $datamail
                );
            
                return Response::forge(View::forge('achat/order/confirm', $data));
	        }
	        
	        else {
	            Session::set_flash('error', Config::get('errormsgs.payment.4202'));
	        }
	    }
	    else {
	        Session::set_flash('error', Config::get('errormsgs.payment.4110'));
	    }
	    
	    return Response::forge(View::forge('achat/order/cancel', array('return_page' => true)));
	}
	
	public function action_cancel()
	{
	    $token = $_REQUEST['token'];
	    if(isset($token)) {
	        // Get order
	        $order = Model_Achat_Order::getCheckoutOrder($token);
	        if(!empty($order)) 
	            $order->cancelPayment($token);
	    }
	    
	    return Response::forge(View::forge('achat/order/cancel'));
	}
	
	public function action_CGV() {
	    return Response::forge(View::forge('achat/order/cgv'));
	}
}
