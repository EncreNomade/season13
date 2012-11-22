<?php

class Controller_Base extends Controller_Rest
{

    public function before()
    {
    	parent::before();
    	
    	// Assign current_user to the instance so controllers can use it
    	$this->current_user = Auth::check() ? Model_13user::find_by_pseudo(Auth::get_screen_name()) : null;
    	
    	$this->remote_path = Fuel::$env == Fuel::DEVELOPMENT ? '/season13/public/' : '/';
    	
    	// Set a global variable so views can use it
    	View::set_global('current_user', $this->current_user);
    }
    
    private static function addToPrestashop($user, $pass) {
        require_once( APPPATH.'classes/custom/PSWebServiceLibrary.php' );
        
        $storeurl = Fuel::$env == Fuel::DEVELOPMENT ? 'http://localhost:8888/prestashop/' : 'http://shop.season13.com/';
        $key = 'LSCWIFSSE16MA015TP5YTSZTMTR5C76M';
        
        try {
            $webService = new PrestaShopWebservice( $storeurl, $key, false );
        }
        catch ( PrestaShopWebserviceException $ex ) {
            $trace = $ex->getTrace(); // Retrieve all information on the error
            $errorCode = $trace[ 0 ][ 'args' ][ 0 ]; // Retrieve the error code
            return array('valid' => false, 'errorCode' => $errorCode, 'errorMessage' => $ex->getMessage());
        }
        
        $xml = $webService->get( array( 'url' => $storeurl.'api/customers?schema=blank' ) );
        $fields = $xml->children()->children();
        
        foreach ( $fields as $key => $field ) {
            switch ($key) {
            case "id_default_group":
                $fields->$key = $user->group;
                break;
            case "passwd":
                $fields->$key = $pass;
                break;
            case "lastname":
                $fields->$key = " ";
                break;
            case "firstname":
                $fields->$key = $user->pseudo;
                break;
            case "email":
                $fields->$key = $user->email;
                break;
            case "id_gender":
                $birth = date_timestamp_get(date_create_from_format('Y-m-d', $user->birthday));
                $age = intval(Date::time_ago($birth, time(), 'year'));
                $fields->$key = $user->sex == "m" ? 1 : ($age > 26 ? 2 : 3);
                break;
            case "birthday":
                $fields->$key = $user->birthday;
                break;
            case "optin": case "is_guest": case "newsletter": case "deleted":
                $fields->$key = 0;
                break;
            case "active":
                $fields->$key = 1;
                break;
            default:
                break;
            }
        }
        
        $opt = array( 'resource' => 'customers' ); // Resource definition
        $opt[ 'postXml' ] = $xml->asXML();
        
        try {
            $webService->add( $opt );
        }
        catch ( PrestaShopWebserviceException $ex ) {
            $prestatrace = $ex->getTrace(); // Retrieve all information on the error
            $errorCode = $prestatrace[ 0 ][ 'args' ][ 0 ]; // Retrieve the error code
            return array('valid' => false, 'errorCode' => $errorCode, 'errorMessage' => $ex->getMessage());
        }
        
        return array('valid' => true);
    }
	
	public function post_signup_normal()
	{
	    if(!Security::check_token()) {
	        return $this->response(array('valid' => false, 'errorMessage' => "CSRF attack"), 200);
	    }
	    
	    $val = Validation::forge();
    
        $val->add('pseudo', 'Pseudo')
            ->add_rule('required');
        $val->add('email', 'Email')
            ->add_rule('valid_email');
        $val->add('password', 'Password')
            ->add_rule('required');
        
        if ($val->run())
		{
		    $valide = true;
		    // pseudo / email already existe probleme
		    $existuser = Model_13user::find_by_email(Input::post('email'));
		    if($existuser !== null) {
		        $valide = false;
		        return $this->response(array('valid' => false, 'errorType' => 'mail', 'errorMessage' => 'Email existe déjà.'), 200);
		    }
		    else {
    		    $existuser = Model_13user::find_by_pseudo(Input::post('pseudo'));
    		    if($existuser !== null) {
    		        $valide = false;
    		        return $this->response(array('valid' => false, 'errorType' => 'pseudo', 'errorMessage' => 'Pseudo existe déjà.'), 200);
    		    }
		    }
		    
		    if($valide) {
    			$auth = Auth::instance();
                
                $fbID = '0';
                $avatar = Input::post('avatar');
                
                // check if user has signup with FB
                if( Input::post('fbToken') && Input::post('fbToken') != 'empty' ){
                    $fbUser = json_decode(@file_get_contents('https://graph.facebook.com/me?access_token=' . Input::post('fbToken')));
                    if( is_object($fbUser) && isset($fbUser->id) ){
                        $fbID = $fbUser->id;
                        $avatar = 'https://graph.facebook.com/' . $fbUser->id . '/picture';
                    }
                }
                
    			// check the credentials. This assumes that you have the previous table created
    			if ( $auth->create_user(Input::post('pseudo'), 
    			                        Input::post('password'),
    			                        Input::post('email'),
    			                        Input::post('portable'),
    			                        Input::post('group'),
    			                        $avatar,
    			                        Input::post('sex'),
    			                        Input::post('birthday'),
    			                        Input::post('pays'),
    			                        Input::post('codpos'),
    			                        'mail', // not dispo in html form !
                                        $fbID) )
    			{
    			    // Log in the user
    			    $res = $auth->login(Input::post('email'), Input::post('password'));
    				// credentials ok, go right in
    				$this->current_user = Model_13user::find_by_pseudo(Auth::get_screen_name());
    				// Set a global variable so views can use it
    				View::set_global('current_user', $this->current_user);
    				
    				// Save in prestashop
    				//$prestasave = Controller_Base::addToPrestashop($this->current_user, Input::post('password'));
    				
    				//if($prestasave['valid']) {
    				    return $this->response(array('valid' => true, 'redirect' => $this->remote_path), 200);
    				//}
    				//else {
    				//    $this->current_user->delete();
    				//    return $this->response($prestasave, 200);
    				//}
    			}
    			else
    			{
    				return $this->response(array('valid' => false, 'errorMessage' => 'Echec à créer utilisateur'), 200);
    			}
			}
		}
		else 
		{
		    return $this->response(array('valid' => false, 'error' => $val->error()), 200);
		}
	}
	
	
	
	public function post_login_normal()
	{
	    //if(!Security::check_token()) {
	    //    return $this->response(array('valid' => false, 'errorMessage' => "CSRF attack"), 200);
	    //}
	    
		// Already logged in
		Auth::check() and $this->response(array('valid' => true, 'redirect' => $this->remote_path), 200);

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
				$this->response(array('valid' => true, 'redirect' => $this->remote_path), 200);
			}
			else
			{
				$this->response(array('valid' => false, 'errorMessage' => 'Erreur d\'authentification'), 200);
			}
		}
	}
	
	 /**
      * Facebook login action
      * 
      * need a valid facebook token to connect the user
      *
	  * @access  public
	  * @return  void
      */
	public function post_login_fb()
	{
	    // Already logged in
		Auth::check() and $this->response(array('valid' => true, 'redirect' => $this->remote_path), 200);

        $fbUser = json_decode(@file_get_contents('https://graph.facebook.com/me?access_token=' . Input::post('fbToken')));
        
        if( !is_object($fbUser) && !isset($fbUser->id) )
            $this->response(array('valid' => false, 'errorMessage' => 'Problème de connexion à Facebook'), 200);
        else {
            $auth = Auth::instance('fbauth');
    
            // check the credentials. This assumes that you have the previous table created
            if (Auth::check() or $auth->login($fbUser->email, $fbUser->id))
            {
                // credentials ok, go right in
                $this->current_user = Model_13user::find_by_pseudo(Auth::get_screen_name());
                $this->response(array('valid' => true, 'redirect' => $this->remote_path), 200);
            }
            else
            {
                $this->response(array('valid' => false, 'errorMessage' => 'Erreur d\'authentification'), 200);
            }
        }
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
		$this->response(array('valid' => true, 'redirect' => $this->remote_path), 200);
	}
	
	
	
	public function post_update()
	{
	    if(!Security::check_token()) {
	        return $this->response(array('valid' => false, 'errorMessage' => "Veuille recharger la page et puis réessayer."), 200);
	    }
	    
	    $auth = Auth::instance();
        
        $update = array('old_password' => Input::post('oldPass'));
        
        if(Input::post('newPass') != "" && Input::post('newPass') != Input::post('oldPass'))
            $update['password'] = Input::post('newPass');
        if(Input::post('sex') != $this->current_user->sex)
            $update['sex'] = Input::post('sex');
        if(Input::post('birthday') != $this->current_user->birthday) {
            $format = 'd/m/Y';
            $birth = date_create_from_format($format, (string)Input::post('birthday'));
            $update['birthday'] = date_format($birth, 'Y-m-d');
        }
        if(Input::post('pays') != "" && Input::post('pays') != $this->current_user->pays)
            $update['pays'] = Input::post('pays');
        if(Input::post('codpos') != "" && Input::post('codpos') != $this->current_user->code_postal)
            $update['code_postal'] = Input::post('codpos');
        
        $valide = true;
		try {
		    $auth->update_user($update);
		}
		catch (SimpleUserWrongPassword $e) {
		    $this->response(array('valid' => false, 'type' => 'password', 'errorMessage' => 'Ton mot de passe est incorrect'), 200);
		    $valide = false;
		}
		catch (SimpleUserUpdateException $e) {
		    var_dump($e);
		    switch ($e->code) {
		    case 1:
		        break;
		    }
		    $valide = false;
		}
		
		if($valide) {
		    $this->current_user = Model_13user::find_by_pseudo(Auth::get_screen_name());
		    // Set a global variable so views can use it
		    View::set_global('current_user', $this->current_user);
		    $this->response(array('valid' => true, 'redirect' => $this->remote_path), 200);
		}
	}
	
	
	
    
    
    public function get_story_access() {
        $epid = Input::get('epid') ? Input::get('epid') : null;
        
        Config::load('errormsgs', true);
        $codes = (array) Config::get('errormsgs.story_access', array ());
        
        if(is_null($epid)) {
            $this->response(array('valid' => false, 'errorCode' => '102', 'errorMessage' => $codes[102]), 200);
        }
        else {
            $access = Controller_Story::requestAccess($epid, $this->current_user);
            
            $this->response($access, 200);
        }
    }
    
}
