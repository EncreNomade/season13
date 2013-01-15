<?php

class Controller_Achat_Order extends Controller_Season13
{
    
    public function before()
    {        
    	parent::before();
    }

	public function action_view()
	{
	    $order = Model_Achat_Order::getCurrentOrder();
	    
	    $this->template->title = 'Commande - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
		$this->template->content = View::forge('achat/order/view');
	}
}
