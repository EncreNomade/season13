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

		$this->user = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
			->where_open()
			->where('pseudo', '=', $pseudo_or_email)
			->or_where('email', '=', $pseudo_or_email)
			->where_close()
			->where('fbid', '=', $fbID)
			->from(\Config::get('simpleauth.table_name'))
			->execute(\Config::get('simpleauth.db_connection'))->current();

		return $this->user ?: false;
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
			$this->user = \Config::get('simpleauth.guest_login', true) ? static::$guest_login : false;
			\Session::delete('pseudo');
			\Session::delete('login_hash');
			return DB::last_query();
		}

		\Session::set('pseudo', $this->user['pseudo']);
		\Session::set('login_hash', $this->create_login_hash());
		\Session::instance()->rotate();
		return true;
	}
} 


