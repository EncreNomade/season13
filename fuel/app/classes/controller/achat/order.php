<?php

class Controller_Achat_Order extends Controller_Frontend
{
    public function action_view()
	{
        $this->template->js_supp = 'achat/order.js';
        $this->template->css_supp = 'order.css';

	    if(!empty($this->cart)) {
	        $products = $this->cart->getProducts();
	        $currency = $this->cart->getCurrency();
	        $total = $this->cart->addition();
	        $ht = round($total * (1 - $this->cart->tax_rate/100), 2);
	        $tax = $total - $ht;
	        
	        // No product
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
    	                'tva' => number_format($this->cart->tax_rate/100, 2, '.', ''),
    	                'tax' => $tax,
    	                'products' => $products,
    	                'currency' => $currency,
    	            );
    	            
    	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
    	            $this->template->content = View::forge('achat/order/view', $data);
    	        }
	        }
	        else {
	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	            $this->template->content = View::forge('achat/order/empty');
	        }
	    }
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
    	                return Response::forge(View::forge('achat/order/confirm', $result['confirmData']));
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
}
