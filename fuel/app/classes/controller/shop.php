<?php

class Controller_Shop extends Controller_Template
{
    
    public function before()
    {        
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	View::set_global('remote_path', Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/');
    	
    	// Set supplementation css and js file
        $this->template->css_supp = '';
        $this->template->js_supp = '';
    }

	public function action_panier()
	{
	    
	
	    $this->template->title = 'Panier - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
		$this->template->content = View::forge('shop/panier');
	}

	public function action_paiement()
	{
	    $this->template->title = 'Paiement - SEASON 13, Histoire Interactive | Feuilleton Multiplateforme | Livre Jeux | HTML5';
		$this->template->content = View::forge('shop/paiement');
	}

}
