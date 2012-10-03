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
    }

	public function action_index()
	{
		$this->template->title = 'Story &raquo; Index';
		$this->template->content = View::forge('story/index');
	}

}