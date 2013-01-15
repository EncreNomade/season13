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
	    $current_order = Session::get('current_order');
	    if($current_order && $current_order->secure_key == $cart->secure_key) {
	        // Lock cart
	        $cart->ordered = 1;
	        
	        return $current_order;
	    }
	    
	    // Cart already ordered
	    if($cart->ordered) 
	        return false;
	    // User not defined in cart
	    if(empty($cart->user_id))
	        return false;
	
	    $order = self::forge(array(
	        'user_id' : $cart->user_id,
	        'user_addr' : "",
	        'cart_id' : $cart->id,
	        'country_code' : $cart->country_code,
	        'state' : "ORDER",
	        'secure_key' : $cart->secure_key,
	        'payment' : "",
	        'total_paid_taxed' : 0,
	        'currency_code' : $cart->currency_code
	    ));
	    
	    if($order && $order->save()) {
	        $order->cart = $cart;
	        // Lock cart
	        $cart->ordered = 1;
	        
	        // Save to session
	        Session::set('current_order', $order);
	        
	        return $order;
	    }
	    else {
	        throw new CartException(Config::get('errormsgs.payment.4101'), 4101);
	    }
	}
	
	public static function getCurrentOrder() {
	    $current_order = Session::get('current_order');
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
	
	    Autoloader::load('Payment');
	
	    if( !is_subclass_of($payment, 'Payment') ) {
	        throw new CartException(Config::get('errormsgs.payment.4102'), 4102);
	    }
	    
	    $payment->passOrder($this);
	}
}
