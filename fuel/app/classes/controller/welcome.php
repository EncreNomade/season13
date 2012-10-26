<?php

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 * 
 * @package  app
 * @extends  Controller
 */
class Controller_Welcome extends Controller_Template
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
    
    public function action_concept() {
        $this->template->title = 'Concept de SEASON13';
        // Set supplementation css and js file
        $this->template->css_supp = 'concept.css';
        $this->template->js_supp = '';
        
        $this->template->content = View::forge('welcome/concept');
    }

	/**
	 * The basic welcome message
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
	    // Data
	    $data['admin_13episodes'] = Model_Admin_13episode::find('all');
	
	    $this->template->title = 'SEASON13';
	    // Set supplementation css and js file
	    $this->template->css_supp = 'welcome.css';
	    $this->template->js_supp = 'welcome.js';
	    
	    $this->template->content = View::forge('welcome/index', $data);
	}

	/**
	 * The 404 action for the application.
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		$this->template->title = 'SEASON13';
		
		$this->template->content = View::forge('welcome/404');
	}
}
