<?php

/**
 * The Basic Template Controller.
 */
class Controller_Season13 extends Controller_Template
{
    public function before()
    {        
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	//$this->cart = empty($this->cart) ? Model_Achat_Cart::createCart(Input::real_ip()) : $this->cart;

        $this->remote_path = Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/';
        $this->base_url = Fuel::$env == Fuel::DEVELOPMENT ? 'localhost:8888/season13/public/' : "http://".$_SERVER['HTTP_HOST']."/";
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	View::set_global('remote_path', $this->remote_path);
    	View::set_global('base_url', $this->base_url);
    	//View::set_global('cart', $this->cart);
    }
}