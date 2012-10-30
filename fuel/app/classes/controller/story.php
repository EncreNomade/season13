<?php

class Controller_Story extends Controller_Template
{
    public $template = 'story/template';
    
    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	
    	$epid = Input::get('ep');
    	
    	if(self::requestAccess($epid)) {
    	    $this->episode = Model_Admin_13episode::find($epid);
    	    $this->comments = Model_Admin_13comment::find_by_epid($epid);
    	    
    	    View::set_global('episode', $this->episode);
    	}
    	else {
    	    Response::redirect('404');
    	}
    }
    
    private function requestAccess($epid) {
        return true;
    }

	public function action_index()
	{
	    $capable = false;
	    // Check user browser capacity
	    // Process based on the browser name
	    switch (Agent::browser())
	    {
	        case 'Firefox':
	            if(Agent::version() < 3.7)
	                $capable = false;
	            else 
	                $capable = true;
	            break;
	        case 'IE':
	            if(Agent::version() < 9)
	                $capable = false;
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
	            $capable = false;
	            break;
	        default:
	            $capable = true;
	            break;
	    }
	
	    if($capable) {
    	    $this->template->title = stripslashes($this->episode->title);
    	}
    	else {
    	    Response::redirect('http://season13.com/upgradenav');
    	}
	}
}