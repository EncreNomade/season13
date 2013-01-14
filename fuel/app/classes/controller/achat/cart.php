<?php

class Controller_Achat_Cart extends Controller {
    private $cart;

    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	$this->remote_path = Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/';
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);

        $this->cart = Model_Achat_Cart::create();
    }
    
    public function action_add()
    {
        $pid = Input::post('productId');

        if ($this->cart->addProduct($pid)) {
            $data = array();
            $data['remote_path'] = $this->remote_path;
            $data['products'] = $this->cart->getProducts();

            return View::forge('achat/cart', $data);
        }
    }
}

