<?php

class Controller_Achat_Order extends Controller_Frontend
{
    
    public function before()
    {        
    	parent::before();
    }

	public function action_view()
	{
	    $order = Model_Achat_Order::getCurrentOrder();
	    $cart = false;
	    $currency = false;
	    if($order) { 
	        $cart = $order->getCart();
	        $products = $cart->getProducts();
	        $currency = $cart->getCurrency();
	    }
	    
	    if(!$order || !$cart || count($products) == 0) {
	        $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
	        $this->template->content = View::forge('achat/order/empty', $data);
	    }
	    
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
