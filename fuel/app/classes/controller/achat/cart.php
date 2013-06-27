<?php

class Controller_Achat_Cart extends Controller_Ajax {

    public function before() {
        parent::before();
        
        if(empty($this->cart)) {
            // Create cart for user already logged in
            if(is_null($this->current_user))
                $this->cart = Model_Achat_Cart::createCart(Input::real_ip());
            // Create cart for guest
            else $this->cart = Model_Achat_Cart::createCart(Input::real_ip(), $this->current_user->pays, $this->current_user->id);
        }
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
        $data = array();
        $data['remote_path'] = $this->remote_path;
        $data['cart'] = $this->cart;
        
        $cartpid = Input::post('cart_product_id');
        $ref = Input::post('product_ref');
        
        if(empty($cartpid) || empty($ref)) {
            Session::set_flash('cart_error', "Erreur de panier, veuilles rafraichir la page");
        }
        else {
            $product = Model_Achat_13product::find_by_reference( $ref );
            $pid = isset($product) ? $product->id : null;
    
            try {
                $this->cart->removeProduct($pid, $cartpid);            
            } catch (CartException $e) {
                Session::set_flash('cart_error', $e->getMessage().".");
            }
        }

        return View::forge('achat/cart/cart_view', $data);
    }
    
    public function action_offer()
    {
        $data = array();
        $data['remote_path'] = $this->remote_path;
        $data['cart'] = $this->cart;
        
        if(is_null(Input::post('cart_product_id')) || is_null(Input::post('offer_target'))) {
            Session::set_flash('cart_error', "Erreur de panier, veuilles rafraichir la page");
        }
        else {
            try {
                $this->cart->offerProduct(Input::post('cart_product_id'), Input::post('offer_target'));            
            } catch (CartException $e) {
                Session::set_flash('cart_error', $e->getMessage().".");
            }
        }

        return View::forge('achat/cart/cart_view', $data);
    }
}