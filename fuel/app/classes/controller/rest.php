<?php

/**
 * The Basic Frontend View Controller.
 */
class Controller_Restbase extends Controller_Rest
{
    protected $cart;

    public function before()
    {        
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;

        $this->remote_path = Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/';
        $this->base_url = Fuel::$env == Fuel::DEVELOPMENT ? 'http://localhost:8888/season13/public/' : "http://".$_SERVER['HTTP_HOST']."/";
    	
        // Get cart if cart not exist
        if(empty($this->cart)) {
            // Get cart in session
            $current_cart = Model_Achat_Cart::getCurrentCart();
            
            if(empty($current_cart)) {
                // Create cart for user already logged in
                if(empty($this->current_user))
                    $current_cart = Model_Achat_Cart::createCart(Input::real_ip());
                // Create cart for guest
                else $current_cart = Model_Achat_Cart::createCart(Input::real_ip(), $this->current_user->pays, $this->current_user->id);
            }
            else {
                // Set user in cart if user not existed in cart
                if( $this->current_user )
                    $current_cart->setUser($this->current_user->id);
            }
            $this->cart = $current_cart;
        }
    }
}