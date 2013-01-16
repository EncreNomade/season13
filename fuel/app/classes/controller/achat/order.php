<?php

class Controller_Achat_Order extends Controller_Frontend
{
    
    public function action_view()
	{
	    if($this->cart) {
	        $products = $this->cart->getProducts();
	        $currency = $this->cart->getCurrency();
	        $total = $this->cart->addition();
	        $ht = round($total * (1 - $this->cart->tax_rate/100), 2);
	        $tax = $total - $ht;
	        
	        if($this->current_user) {
    	        // Order the cart
    	        $order = Model_Achat_Order::orderCart($this->cart);
    	        	        
    	        if(!$order || !$this->cart || count($products) == 0) {
    	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
    	            $this->template->content = View::forge('achat/order/empty');
    	        }
    	        else {
    	            $data = array(
    	                'order' => $order,
    	                'cart' => $this->cart,
    	                'total' => $total,
    	                'ht' => $ht,
    	                'tax' => $tax,
    	                'products' => $products,
    	                'currency' => $currency,
    	            );
    	            
    	            $user_address = Model_User_Address::query()->where('user_id', $this->current_user->id)->get_one();
    	            View::set_global('user_address', $user_address);
    	            
    	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
    	        	$this->template->content = View::forge('achat/order/view', $data);
    	        }
	        }
	        // Show user login
	        else {
	            $data = array(
	                'cart' => $this->cart,
	                'total' => $total,
	                'ht' => $ht,
	                'tax' => $tax,
	                'products' => $products,
	                'currency' => $currency,
	            );
	            
	            $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	            $this->template->content = View::forge('achat/order/view', $data);
	        }
	    }
	    else {
	        $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	        $this->template->content = View::forge('achat/order/empty');
	    }
	}
}
