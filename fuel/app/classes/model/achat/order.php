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
		'currency_code'
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
	    if($current_order && $current_order->secure_key == $cart->secure_key) {
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
	        'currency_code' => $cart->currency_code
	    ));
	    
	    if($order && $order->save()) {
	        $order->cart = $cart;
	        // Lock cart
	        $cart->ordered = 1;
	        
	        // Save to session
	        Session::set('current_order', $order->id);
	        
	        return $order;
	    }
	    else {
	        throw new CartException(Config::get('errormsgs.payment.4101'), 4101);
	    }
	}
	
	public static function getCurrentOrder() {
	    $current_order_id = Session::get('current_order');
	    $current_order = self::find($current_order_id);
	    
	    $current_cart = Model_Achat_Cart::getCurrentCart();
	    
	    if($current_order && $current_cart && $current_order->secure_key == $current_cart->secure_key) {
	        return $current_order;
	    }
	    else return false;
	}
	
	public function getCart() {
	    if(is_null($this->cart)) {
	        $this->cart = Model_Achat_Cart::find($this->cart_id);
	        
	        if(is_null($this->cart)) {
	            throw new CartException(Config::get('errormsgs.payment.4104'), 4104);
	        }
	    }
	    
	    return $this->cart;
	}
	
	public function suspendOrder() {
	    $this->cart->ordered = 0;
	}
	
	public function payWith($payment) {
	    // Panier not until ordered
	    if(!$this->cart->ordered) {
	        throw new CartException(Config::get('errormsgs.payment.4103'), 4103);
	    }
	    if(empty($this->cart->user_id))
	        throw new CartException(Config::get('errormsgs.payment.4106'), 4106);
	    if(empty($this->user_addr))
	        throw new CartException(Config::get('errormsgs.payment.4107'), 4107);
	    if($this->state != "ORDER")
	        throw new CartException(Config::get('errormsgs.payment.4108'), 4108);
	
	    Autoloader::load('Payment');
	
	    if( !is_subclass_of($payment, 'Payment') ) {
	        throw new CartException(Config::get('errormsgs.payment.4102'), 4102);
	    }
	    
	    $this->payment = $payment->name;
	    $this->save();
	    
	    $payment->passOrder($this);
	}
	
	
	public function finalize($paid) {
	    // Verification
	    if(empty($this->cart->user_id))
	        throw new CartException(Config::get('errormsgs.payment.4106'), 4106);
        if(empty($this->user_addr))
            throw new CartException(Config::get('errormsgs.payment.4107'), 4107);
        if($this->state != "ORDER")
	        throw new CartException(Config::get('errormsgs.payment.4108'), 4108);
	    
	    // Update order info
	    if(empty($this->user_id))
	        $this->user_id = $this->cart->user_id;
	    $this->total_paid_taxed = $paid;
	    
	    $user = $this->cart->getUser();
	    $products = $this->cart->getProducts();
	    $fails = array();
	    
	    // Save user possesion information
	    foreach ($products as $product) {
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
