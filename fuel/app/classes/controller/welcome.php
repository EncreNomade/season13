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
        $this->template->title = 'Concept de SEASON 13';
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
	
	    $this->template->title = 'SEASON 13 Voodoo Connection';
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
		$this->template->title = 'SEASON 13 Voodoo Connection';
		
		$this->template->content = View::forge('welcome/404');
	}
	
	/**
	 * The upgrade navigator action for the application.
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_upgradenav() {
	    // Init data
	    $data['change']  = false;
	    $data['maj'] = false;
	    $data['browser'] = '';
	    
	    $capable = true;
	    
	    // Check user browser capacity
	    // Process based on the browser name
	    switch (Agent::browser())
	    {
	        case 'Firefox':
	            if(Agent::version() < 3.7) {
	                $capable = false;
	                $data['maj'] = true;
	                $data['browser'] = 'Firefox';
	            }
	            else 
	                $capable = true;
	            break;
	        case 'IE':
	            if(Agent::version() < 9) {
	                $capable = false;
	                if(Agent::platform() == 'Win7') {
	                    $data['maj'] = true;
	                    $data['browser'] = 'IE';
	                }
	                else {
	                    $data['change'] = true;
	                }
	            }
	            else 
	                $capable = true;
	            break;
	        case 'Chrome':
	            $capable = true;
	            break;
	        case 'Safari':
	            $capable = true;
	            break;
	        case 'Unknown':
	            $data['change'] = true;
	            $capable = false;
	            break;
	        default:
	            $capable = true;
	            break;
	    }
	
	    $this->template->title = 'SEASON 13 Voodoo Connection';
	    $this->template->content = View::forge('welcome/upgradenav', $data);
	}
	
	
	public function action_mentionslegals() {
	    $this->template->title = 'SEASON 13 Voodoo Connection';
	    
	    $this->template->content = View::forge('welcome/mentionslegals');
	}
	
}
