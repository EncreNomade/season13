<?php

class Controller_Achat_Orderadmin extends Controller_Backend
{
    public function action_paid()
	{
	    $orders = Model_Achat_Order::query()->where('state', 'FINALIZE')->limit(50)->get();
	    $data = array('title' => "Commandes effectuées", 'orders' => $orders);
	    
	    $this->template->title = "Commandes";
	    $this->template->content = View::forge('achat/order/list', $data);
	}
	
	public function action_recent()
	{
	    $orders = Model_Achat_Order::query()->limit(50)->get();
	    $data = array('title' => "Commandes plus récentes", 'orders' => $orders);
	    
	    $this->template->title = "Commandes";
	    $this->template->content = View::forge('achat/order/list', $data);
	}
	
	public function action_failed()
	{
	    $orders = Model_Achat_Order::query()->where('state', '=', 'CANCEL')->or_where('state', '=', 'FAIL')->or_where('state', '=', 'STARTPAY')->get();
	    $data = array('title' => "Commandes échouées", 'orders' => $orders);
	    
	    $this->template->title = "Commandes";
	    $this->template->content = View::forge('achat/order/list', $data);
	}
	
	public function action_abandon()
	{
	    $orders = Model_Achat_Order::query()->where('state', 'ORDER')->limit(50)->get();
	    $data = array('title' => "Commandes abandonnées", 'orders' => $orders);
	    
	    $this->template->title = "Commandes";
	    $this->template->content = View::forge('achat/order/list', $data);
	}
	
	public function action_view($id = null)
	{
	    is_null($id) and Response::redirect('404');
	    $order = Model_Achat_Order::find($id);
	    
	    $data = array('order' => $order);

		$this->template->title = "Commande";
		$this->template->content = View::forge('achat/order/adminview', $data);
	}
}