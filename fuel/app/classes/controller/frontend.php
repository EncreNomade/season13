<?php

/**
 * The Basic Frontend View Controller.
 */
class Controller_Frontend extends Controller_Season13
{
    protected $cart;

    public function before()
    {        
    	parent::before();
    	
        // Get cart if cart not exist
        if(empty($this->cart)) {
            // Get cart in session
            $current_cart = Model_Achat_Cart::getCurrentCart();
            
            /*
            if(empty($current_cart)) {
                // Create cart for user already logged in
                if(empty($this->current_user))
                    $current_cart = Model_Achat_Cart::createCart(Input::real_ip());
                // Create cart for guest
                else $current_cart = Model_Achat_Cart::createCart(Input::real_ip(), $this->current_user->pays, $this->current_user->id);
            }
            else {*/
            if($current_cart) {
                // Set user in cart if user not existed in cart
                if( $this->current_user )
                    $current_cart->setUser($this->current_user->id);
                $this->cart = $current_cart;
            }
            else $this->cart = null;
        }
    	
    	// Set a global variable so views can use it
    	View::set_global('cart', $this->cart);
    }
}