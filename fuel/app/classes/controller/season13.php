<?php

/**
 * The Basic Template Controller.
 */
class Controller_Season13 extends Controller_Template
{
    protected $current_user;
    protected $remote_path;
    protected $base_url;

    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;

        $this->remote_path = Config::get('custom.remote_path');
        $this->base_url = Config::get('custom.base_url');
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    	View::set_global('remote_path', $this->remote_path);
    	View::set_global('base_url', $this->base_url);
    }
}