<?php


class Auth_Login_FBAuth extends Auth\Auth_Login_SimpleAuth
{
    public static function _init()
	{
		\Config::load('fbauth', true);
	}
    
    public function validate_user($pseudo_or_email = '', $fbID = '')
	{
		$pseudo_or_email = trim($pseudo_or_email) ?: trim(\Input::post(\Config::get('simpleauth.pseudo_post_key', 'pseudo')));

		if (empty($pseudo_or_email) or empty($fbID))
		{
			return false;
		}

		$result = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
			->where_open()
			->where('pseudo', '=', $pseudo_or_email)
			->or_where('email', '=', $pseudo_or_email)
			->or_where('fbid', '=', $fbID)
			->where_close()
			->from(\Config::get('simpleauth.table_name'))
			->as_object('Model_13user')
			->execute(\Config::get('simpleauth.db_connection'));
		
		if(count($result) > 0) {
		    $this->user = $result->current();
		    
    		if($this->user->fbid == 0) {
    		     $this->user->fbid = $fbID;
    		     
    		     // Update user
    		     if($this->user->save() === false)
    		         return false; // Fail update
    		     else return $this->user; // Success update
    		}
    		else if($this->user->fbid != $fbID)
    		    return false;
    		else return $this->user;
		}
		else return false;
	}

	/**
	 * Login user
	 *
	 * @param   string
	 * @param   string
	 * @return  bool
	 */
	public function login($pseudo_or_email = '', $fbID = '')
	{
		if ( ! ($this->user = $this->validate_user($pseudo_or_email, $fbID)))
		{
			\Session::delete('pseudo');
			\Session::delete('login_hash');
			return false;
		}

		\Session::set('pseudo', $this->user['pseudo']);
		\Session::set('login_hash', $this->create_login_hash());
		\Session::instance()->rotate();
		return true;
	}
} 


