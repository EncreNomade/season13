<?php

/**
 * The Basic Backend View Controller.
 */
class Controller_Backend extends Controller_Season13
{
    public $template = 'admin/template';

    public function before()
    {        
    	parent::before();
    	
    	if ( !Auth::member(100) )
    	{
    		Response::redirect('404');
    	}
    }
}