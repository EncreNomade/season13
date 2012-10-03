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
    	
    	// Set supplementation css and js file
        $this->template->css_supp = '';
        $this->template->js_supp = '';
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
	
	    $this->template->title = 'Welcome';
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
		return Response::forge(ViewModel::forge('welcome/404'), 404);
	}
}
