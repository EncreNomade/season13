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
	    $this->template->title = stripslashes($this->episode->title);
	}
	
	public function action_upgradenav() {
	    return View::forge('story/upgradenav');
	}

}