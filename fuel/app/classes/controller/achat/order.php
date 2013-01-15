<?php

class Controller_Achat_Order extends Controller_Frontend
{
    
    public function action_view()
	{
	    // Get cart existed
        $cart = Model_Achat_Cart::getCurrentCart();
	    
	    if($cart) {
	        // Order the cart
	        $order = Model_Achat_Order::orderCart($cart);
	        
	        if($order) { 
	            $cart = $order->getCart();
	            $products = $cart->getProducts();
	            $currency = $cart->getCurrency();
	        }
	        
	        if(!$order || !$cart || count($products) == 0) {
	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	            $this->template->content = View::forge('achat/order/empty', $data);
	        }
	        else {
	            $data = array(
	                'order' => $order,
	                'cart' => $cart,
	                'products' => $products,
	                'currency' => $currency,
	            );
	            View::set_global('user_adresse', $user_adresse);
	            
	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	        	$this->template->content = View::forge('achat/order/view', $data);
	        }
	    }
	    else {
	        $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	        $this->template->content = View::forge('achat/order/empty', $data);
	    }
	}
}
