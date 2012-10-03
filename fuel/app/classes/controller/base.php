<?php

class Controller_Base extends Controller_Rest
{

    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    }
	
	public function post_signup_normal() 
	{
	    $val = Validation::forge();
    
        $val->add('pseudo', 'Pseudo')
            ->add_rule('required');
        $val->add('email', 'Email')
            ->add_rule('valid_email');
        $val->add('password', 'Password')
            ->add_rule('required');
        
        if ($val->run())
		{
			$auth = Auth::instance();

			// check the credentials. This assumes that you have the previous table created
			if ( $auth->create_user(Input::post('pseudo'), 
			                        Input::post('password'),
			                        Input::post('email'),
			                        Input::post('portable'),
			                        Input::post('group'),
			                        Input::post('avatar'),
			                        Input::post('sex'),
			                        Input::post('birthday'),
			                        Input::post('notif')) )
			{
			    // Log in the user
			    $auth->login(Input::post('email'), Input::post('password'));
				// credentials ok, go right in
				$this->current_user = Model_13user::find_by_pseudo(Auth::get_screen_name());
				// Set a global variable so views can use it
				View::set_global('current_user', $this->current_user);
				$this->response(array('valid' => true, 'redirect' => '/'), 200);
			}
			else
			{
				$this->response(array('valid' => false, 'error' => 'Echec à créer utilisateur'), 200);
			}
		}
		else 
		{
		    $this->response(array('valid' => false, 'error' => $val->error()), 200);
		}
	}
	
	public function post_link_fb() 
	{
        $val = Validation::forge();
    
        $val->add('pseudo', 'Pseudo')
            ->add_rule('required');
        $val->add('email', 'Email')
            ->add_rule('valid_email');
        $val->add('password', 'Password')
            ->add_rule('required');
        $val->add('fbid', 'Facebook id')
            ->add_rule('required');
        
        if ($val->run())
		{
			$auth = Auth::instance();

			// check the credentials. This assumes that you have the previous table created
			if ( $auth->create_user(Input::post('pseudo'), 
			                        Input::post('password'),
			                        Input::post('email'),
			                        Input::post('portable'),
			                        Input::post('group'),
			                        Input::post('avatar'),
			                        Input::post('sex'),
			                        Input::post('birthday'),
			                        Input::post('notif'), // Facebook id registration
			                        Input::post('fbid') ) )
			{
			    // Log in the user
			    $auth->login(Input::post('email'), Input::post('password'));
				// credentials ok, go right in
				$this->current_user = Model_13user::find_by_pseudo(Auth::get_screen_name());
				// Set a global variable so views can use it
				View::set_global('current_user', $this->current_user);
				$this->response(array('valid' => true, 'redirect' => '/'), 200);
			}
			else
			{
				$this->response(array('valid' => false, 'error' => 'Echec à créer utilisateur'), 200);
			}
		}
		else 
		{
		    $this->response(array('valid' => false, 'error' => $val->error()), 200);
		}
	}
	
	public function post_login_normal()
	{
		// Already logged in
		Auth::check() and $this->response(array('valid' => true, 'redirect' => '/'), 200);

		$val = Validation::forge();

		$val->add('identifiant', 'Email or Username')
		    ->add_rule('required');
		$val->add('password', 'Password')
		    ->add_rule('required');

		if ($val->run())
		{
			$auth = Auth::instance();

			// check the credentials. This assumes that you have the previous table created
			if (Auth::check() or $auth->login(Input::post('identifiant'), Input::post('password')))
			{
				// credentials ok, go right in
				$this->current_user = Model_13user::find_by_pseudo(Auth::get_screen_name());
				$this->response(array('valid' => true, 'redirect' => '/'), 200);
			}
			else
			{
				$this->response(array('valid' => false, 'error' => 'Erreur d\'authentification'), 200);
			}
		}
	}
	
	public function post_login_fb()
	{
	    
	}
	
	/**
	 * The logout action.
	 *
	 * @access  public
	 * @return  void
	 */
	public function get_logout()
	{
		Auth::logout();
		$this->response(array('valid' => true, 'redirect' => '/'), 200);
	}
	
	
	
	public function action_panel() {
	    $data = array(); //stores variables going to views
        $data['current_user'] = $this->current_user;
	        
	    return View::forge('base/panel', $data);
	}
    
}
