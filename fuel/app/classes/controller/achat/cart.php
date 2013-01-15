<?php

class Controller_Achat_Cart extends Controller_Ajax {
    
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

