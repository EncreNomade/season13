<?php

/**
 * The Basic Ajax View Controller.
 */
class Controller_Ajax extends Controller
{
    protected $cart;
    
    public function before()
    {        
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    
        $this->remote_path = Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/';
        $this->base_url = Fuel::$env == Fuel::DEVELOPMENT ? 'localhost:8888/season13/public/' : "http://".$_SERVER['HTTP_HOST']."/";
    	
        // Get cart if cart not exist
        if(!isset($this->cart)) {
            // Get cart in session
            $current_cart = Model_Achat_Cart::getCurrentCart();
            if(!$current_cart) {
                // Create cart for user already logged in
                if(is_null($this->current_user))
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
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	View::set_global('remote_path', $this->remote_path);
    	View::set_global('base_url', $this->base_url);
    	View::set_global('cart', $this->cart);
    }
}