<?php

class Model_Achat_Order extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'user_addr',
		'cart_id',
		'country_code',
		'state',
		'secure_key',
		'payment',
		'total_paid_taxed',
		'currency_code',
		'transaction_infos',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);
	
	public static function orderCart($cart) {
	    // Existed order
	    $current_order_id = Session::get('current_order');
	    $current_order = self::find($current_order_id);
	    if(isset($current_order->secure_key) && $current_order->secure_key == $cart->secure_key) {
	        // Lock cart
	        $cart->ordered = 1;
	        
	        return $current_order;
	    }
	    
	    // Cart already ordered
	    //if($cart->ordered) 
	    //    return false;
	    // User not defined in cart
	    if(empty($cart->user_id))
	        return false;
	
	    $order = self::forge(array(
	        'user_id' => $cart->user_id,
	        'user_addr' => "",
	        'cart_id' => $cart->id,
	        'country_code' => $cart->country_code,
	        'state' => "ORDER",
	        'secure_key' => $cart->secure_key,
	        'payment' => "",
	        'total_paid_taxed' => 0,
	        'currency_code' => $cart->currency_code,
	        'transaction_infos' => Format::forge(array())->to_json(),
	    ));
	    
	    if($order && $order->save()) {
	        $order->cart = $cart;
	        // Lock cart
	        $cart->ordered = 1;
	        
	        // Save to session
	        Session::set('current_order', $order->id);
	        
	        // Save cart ordered state
	        $cart->save();
	        
	        return $order;
	    }
	    else {
	        throw new CartException(Config::get('errormsgs.payment.4101'), 4101);
	    }
	}
	
	public static function getCurrentOrder() {
	    $current_order_id = Session::get('current_order');
	    if($current_order_id) {
	        $current_order = self::find($current_order_id);
	    
	        $current_cart = Model_Achat_Cart::getCurrentCart();
	        
	        if($current_order && $current_cart && $current_order->secure_key == $current_cart->secure_key) {
	            return $current_order;
	        }
	        else return false;
	    }
	    else return false;
	}
	
	public function getCart() {
	    if(empty($this->cart)) {
	        $this->cart = Model_Achat_Cart::find($this->cart_id);
	        
	        if(empty($this->cart)) {
	            throw new CartException(Config::get('errormsgs.payment.4104'), 4104);
	        }
	    }
	    
	    return $this->cart;
	}
	
	public function checkout($token) {
	    // Verification
	    if(empty($this->cart->user_id))
	        throw new CartException(Config::get('errormsgs.payment.4106'), 4106);
	        
	    // Set user address
	    if(empty($this->user_addr)) {
	        $addr = Model_User_Address::getUserAdress($this->cart->user_id);
	        if(empty($addr))
    	        throw new CartException(Config::get('errormsgs.payment.4107'), 4107);
    	    else {
    	        $this->user_addr = $addr->id;
    	    }
	    }
	    
	    // Update order state
	    $this->state = "STARTPAY";
	    $this->save();
	
	    // Forbiden double checkout
	    $orders = Session::get('checkout_order');
	    
	    if(isset($orders[$token])) {
	        throw new CartException(Config::get('errormsgs.payment.4109'), 4109);
	    }
	    
	    // Add check out order to session
	    $orders[$token] = $this->id;
	    Session::set('checkout_order', $orders);
	
	    // Delete from session
	    Session::delete('current_order');
	    // Delete cart
	    $this->getCart()->checkout();
	}
	
	public static function getCheckoutOrder($token) {
	    $orders = Session::get('checkout_order');
	    
	    if(isset($orders[$token])) {
	        $order = self::find($orders[$token]);
            return $order;
	    }
	    else {
	        return null;
	    }
	}
	
	public function cancelPayment($token) {
	    // Update order state
        $this->state = "CANCEL";
        $this->save();
        
        // Reactive cart
        $this->getCart()->reactive();
    
        // Update checkout orders
        $orders = Session::get('checkout_order');
        
        // Remove check out order from session
        if(isset($orders[$token])) {
            unset($orders[$token]);
        }
        Session::set('checkout_order', $orders);
    
        // Readd order to session
        Session::set('current_order', $this->id);
	}
	
	public function payWith($payment) {
	    // Panier not until ordered
	    if(!$this->getCart()->ordered) {
	        throw new CartException(Config::get('errormsgs.payment.4103'), 4103);
	    }
	    if(empty($this->getCart()->user_id))
	        throw new CartException(Config::get('errormsgs.payment.4106'), 4106);
	    if(empty($this->user_addr))
	        throw new CartException(Config::get('errormsgs.payment.4107'), 4107);
	
	    Autoloader::load('Payment');
	
	    if( !is_subclass_of($payment, 'Payment') ) {
	        throw new CartException(Config::get('errormsgs.payment.4102'), 4102);
	    }
	    
	    $this->payment = $payment->name;
	    $this->save();
	    
	    $payment->passOrder($this);
	}
	
	
	public function payfailed($payment, $transaction_infos, $paid = 0) {
	    $cart = $this->getCart();
	    
	    // Update order info
	    if(empty($this->user_id))
	        $this->user_id = $cart->user_id;
	    $this->total_paid_taxed = $paid;
	    
	    $this->state = "FAIL";
	    $this->payment = $payment;
	    $this->transaction_infos = Format::forge($transaction_infos)->to_json();
	    $this->save();
	}
	
	
	public function finalize($payment, $transaction_infos, $paid) {
	    $cart = $this->getCart();
	    // Verification
	    if(empty($cart->user_id))
	        throw new CartException(Config::get('errormsgs.payment.4106'), 4106);
	    
	    // Update order info
	    if(empty($this->user_id))
	        $this->user_id = $cart->user_id;
	    $this->total_paid_taxed = $paid;
	    $this->payment = $payment;
	    
	    $user = $cart->getUser();
	    $cartproducts = $this->getCart()->getProducts();
	    $fails = array();
	    
	    // Save user possesion information
	    foreach ($cartproducts as $cartproduct) {
	        $product = $cartproduct->product;
	        $eps = Format::forge($product->content, 'json')->to_array();      
            
            foreach ($eps as $episode) {
                $existed = Model_Admin_13userpossesion::query()->where(
                    array(
                        'user_mail' => $user->email,
                        'episode_id' => $episode,
                        'source' => 8,
                    )
                )->count();
    		
    		    if($existed == 0) {
                    $userpossesion = Model_Admin_13userpossesion::forge(array(
    					'user_mail' => $user->email,
    					'episode_id' => $episode,
    					'source' => 8, // 8 means normal order
    					'source_ref' => $this->id,
    				));
    
    				if ($userpossesion and $userpossesion->save())
    				{
    					;
    				}
    				else {
    				    array_push($fails, $episode);
    				}
    		    }
    		}
	    }
	    
	    $this->state = "FINALIZE";
	    $this->transaction_infos = Format::forge($transaction_infos)->to_json();
	    $this->save();
	    
	    // Successfully set the user possesion
	    if(count($fails) == 0) {
	        return true;
	    }
	    else {
	        $this->fails = $fails;
	        throw new CartException(Config::get('errormsgs.payment.4105'), 4105);
	    }
	}
}
