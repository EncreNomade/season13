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

        $this->cart = is_null($this->cart) ? Model_Achat_Cart::createCart(Input::real_ip()) : $this->cart;
    }
    
    public function action_add()
    {
        $product = Model_Achat_13product::find_by_reference( Input::post('product_ref') );
        $pid = isset($product) ? $product->id : null;

        $data = array();
        $data['remote_path'] = $this->remote_path;
        $data['cart'] = $this->cart;


        try { 
            $this->cart->addProduct($pid); 
        } catch (CartException $e) {
            Session::set_flash('cart_error', $e->getMessage().".");
        }

        return View::forge('achat/cart/cart_view', $data);
    }

    public function action_remove()
    {                
        $product = Model_Achat_13product::find_by_reference( Input::post('product_ref') );
        $pid = isset($product) ? $product->id : null;

        $data = array();
        $data['remote_path'] = $this->remote_path;
        $data['cart'] = $this->cart;

        try {
            $this->cart->removeProduct($pid);            
        } catch (CartException $e) {
            Session::set_flash('cart_error', $e->getMessage().".");
        }


        return View::forge('achat/cart/cart_view', $data);
    }
}

