<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2011 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Auth;


class SimpleUserUpdateException extends \FuelException {}

class SimpleUserWrongPassword extends \FuelException {}

/**
 * SimpleAuth basic login driver
 *
 * @package     Fuel
 * @subpackage  Auth
 */
class Auth_Login_SimpleAuth extends \Auth_Login_Driver
{

	public static function _init()
	{
		\Config::load('simpleauth', true, true, true);
	}

	/**
	 * @var  Database_Result  when login succeeded
	 */
	protected $user = null;

	/**
	 * @var  array  value for guest login
	 */
	protected static $guest_login = array(
		'id' => 0,
		'pseudo' => 'guest',
		'group' => '0',
		'login_hash' => false,
		'email' => false
	);

	/**
	 * @var  array  SimpleAuth class config
	 */
	protected $config = array(
		'drivers' => array('group' => array('SimpleGroup')),
		'additional_fields' => array('profile_fields'),
	);

	/**
	 * Check for login
	 *
	 * @return  bool
	 */
	protected function perform_check()
	{
		$pseudo    = \Session::get('pseudo');
		$login_hash  = \Session::get('login_hash');

		// only worth checking if there's both a pseudo and login-hash
		if ( ! empty($pseudo) and ! empty($login_hash))
		{
			if (is_null($this->user) or ($this->user['pseudo'] != $pseudo and $this->user != static::$guest_login))
			{
				$this->user = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
					->where('pseudo', '=', $pseudo)
					->from(\Config::get('simpleauth.table_name'))
					->execute(\Config::get('simpleauth.db_connection'))->current();
			}

			// return true when login was verified
			if ($this->user and $this->user['login_hash'] === $login_hash)
			{
				return true;
			}
		}

		// no valid login when still here, ensure empty session and optionally set guest_login
		$this->user = \Config::get('simpleauth.guest_login', true) ? static::$guest_login : false;
		\Session::delete('pseudo');
		\Session::delete('login_hash');

		return false;
	}

	/**
	 * Check the user exists before logging in
	 *
	 * @return  bool
	 */
	public function validate_user($pseudo_or_email = '', $password = '')
	{
		$pseudo_or_email = trim($pseudo_or_email) ?: trim(\Input::post(\Config::get('simpleauth.pseudo_post_key', 'pseudo')));
		$password = trim($password) ?: trim(\Input::post(\Config::get('simpleauth.password_post_key', 'password')));

		if (empty($pseudo_or_email) or empty($password))
		{
			return false;
		}

		$password = $this->hash_password($password);
		
		$this->user = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
			->where_open()
			->where('pseudo', '=', $pseudo_or_email)
			->or_where('email', '=', $pseudo_or_email)
			->where_close()
			->where('password', '=', $password)
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
	public function login($pseudo_or_email = '', $password = '')
	{
		if ( ! ($this->user = $this->validate_user($pseudo_or_email, $password)))
		{
			$this->user = \Config::get('simpleauth.guest_login', true) ? static::$guest_login : false;
			\Session::delete('pseudo');
			\Session::delete('login_hash');
			return false;
		}

		\Session::set('pseudo', $this->user['pseudo']);
		\Session::set('login_hash', $this->create_login_hash());
		\Session::instance()->rotate();
		return true;
	}

	/**
	 * Force login user
	 *
	 * @param   string
	 * @return  bool
	 */
	public function force_login($user_id = '')
	{
		if (empty($user_id))
		{
			return false;
		}

		$this->user = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
			->where_open()
			->where('id', '=', $user_id)
			->where_close()
			->from(\Config::get('simpleauth.table_name'))
			->execute(\Config::get('simpleauth.db_connection'))
			->current();

		if ($this->user == false)
		{
			$this->user = \Config::get('simpleauth.guest_login', true) ? static::$guest_login : false;
			\Session::delete('pseudo');
			\Session::delete('login_hash');
			return false;
		}

		\Session::set('pseudo', $this->user['pseudo']);
		\Session::set('login_hash', $this->create_login_hash());
		return true;
	}

	/**
	 * Logout user
	 *
	 * @return  bool
	 */
	public function logout()
	{
		$this->user = \Config::get('simpleauth.guest_login', true) ? static::$guest_login : false;
		\Session::delete('pseudo');
		\Session::delete('login_hash');
		return true;
	}

	/**
	 * Create new user
	 *
	 * @param   string
	 * @param   string
	 * @param   string  must contain valid email address
	 * @param   int     group id
	 * @param   Array
	 * @return  bool
	 */
	public function create_user($pseudo, $password, $email, $portable = "", $group = 3, $avatar = "http://season13.com/assets/img/season13/avatar_default.png", $sex = 'm', $birthday = '', $pays = '', $code_postal = '', $notif = 'mail', $fbid = '0', Array $profile_fields = array(), Array $sns_links = array())
	{
		$password = trim($password);
		$email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);

		if (empty($pseudo) or empty($password) or empty($email))
		{
			throw new \SimpleUserUpdateException('Pseudo, password or email address is not given, or email address is invalid', 1);
		}

		$same_users = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
			->where('pseudo', '=', $pseudo)
			->or_where('email', '=', $email)
			->from(\Config::get('simpleauth.table_name'))
			->execute(\Config::get('simpleauth.db_connection'));

		if ($same_users->count() > 0)
		{
			if (in_array(strtolower($email), array_map('strtolower', $same_users->current())))
			{
				throw new \SimpleUserUpdateException('Email address already exists', 2);
			}
			else
			{
				throw new \SimpleUserUpdateException('Pseudo already exists', 3);
			}
		}
		
		if (empty($avatar))
		    $avatar = "http://season13.com/assets/img/season13/avatar_default.png";

        $format = 'd/m/Y';
        if (empty($birthday))
            $birthday = "22/10/2012";
        $birth = date_create_from_format($format, (string)$birthday);

		$user = array(
			'pseudo'          => (string) $pseudo,
			'password'        => $this->hash_password((string) $password),
			'group'           => ($group == null) ? 3 : (int) $group,
			'email'           => (string) $email,
			'portable'        => (string) $portable,
			'avatar'          => (string) $avatar,
			'sex'             => ($sex == null) ? 'm' : $sex,
			'birthday'        => date_format($birth, 'Y-m-d'),
			'pays'            => (string) $pays,
			'code_postal'     => (string) $code_postal,
			'notif'           => (string) $notif,
			'fbid'            => (string) $fbid,
			'profile_fields'  => ($profile_fields == null) ? serialize(array()) : serialize($profile_fields),
			'sns_links'       => ($sns_links == null) ? serialize(array()) : serialize($sns_links),
			'created_at'      => \Date::forge()->get_timestamp(),
			'updated_at'      => 0,
			'login_hash'      => ''
		);
		$result = \DB::insert(\Config::get('simpleauth.table_name'))
			->set($user)
			->execute(\Config::get('simpleauth.db_connection'));

		return ($result[1] > 0) ? $result[0] : false;
	}

	/**
	 * Update a user's properties
	 * Note: Pseudo cannot be updated, to update password the old password must be passed as old_password
	 *
	 * @param   Array  properties to be updated including profile fields
	 * @param   string
	 * @return  bool
	 */
	public function update_user($values, $pseudo = null)
	{
		$pseudo = $pseudo ?: $this->user['pseudo'];
		$current_values = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
			->where('pseudo', '=', $pseudo)
			->from(\Config::get('simpleauth.table_name'))
			->execute(\Config::get('simpleauth.db_connection'));

		if (empty($current_values))
		{
			throw new \SimpleUserUpdateException('Pseudo not found', 4);
		}

		$update = array();
		if (array_key_exists('pseudo', $values))
		{
			throw new \SimpleUserUpdateException('Pseudo cannot be changed.', 5);
		}
		if (array_key_exists('email', $values))
		{
			throw new \SimpleUserUpdateException('Email cannot be changed.', 6);
		}
		if (array_key_exists('password', $values))
		{
			if (empty($values['old_password'])
				or $current_values->get('password') != $this->hash_password(trim($values['old_password'])))
			{
				throw new \SimpleUserWrongPassword('Old password is invalid');
			}

			$password = trim(strval($values['password']));
			if ($password === '')
			{
				throw new \SimpleUserUpdateException('Password can\'t be empty.', 7);
			}
			$update['password'] = $this->hash_password($password);
			unset($values['password']);
		}
		if (array_key_exists('old_password', $values))
		{
			unset($values['old_password']);
		}/*
		if (array_key_exists('email', $values))
		{
			$email = filter_var(trim($values['email']), FILTER_VALIDATE_EMAIL);
			if ( ! $email)
			{
				throw new \SimpleUserUpdateException('Email address is not valid', );
			}
			$update['email'] = $email;
			unset($values['email']);
		}*/
		if (array_key_exists('group', $values))
		{
			if (is_numeric($values['group']))
			{
				$update['group'] = (int) $values['group'];
			}
			unset($values['group']);
		}
		if (array_key_exists('portable', $values))
		{
		    $portable = $values['portable'];
			if ( !is_numeric($portable) )
			{
				throw new \SimpleUserUpdateException('Portable is not valid', 8);
			}
			$update['portable'] = $portable;
			unset($values['portable']);
		}
		if (array_key_exists('avatar', $values))
		{
		    $avatar = filter_var(trim($values['avatar']), FILTER_VALIDATE_URL);
			if ( ! $avatar)
			{
				throw new \SimpleUserUpdateException('Avatar is not valid', 9);
			}
			$update['avatar'] = $avatar;
			unset($values['avatar']);
		}
		if (array_key_exists('sex', $values))
		{
			if ($values['sex'] == 'm' || $values['sex'] == 'f')
			{
				$update['sex'] = $values['sex'];
			}
			unset($values['sex']);
		}
		if (array_key_exists('birthday', $values))
		{
		    $birthday = strtotime(trim($values['birthday']));
			if ( $birthday === false || $birthday == -1 )
			{
				throw new \SimpleUserUpdateException('Birthday is not valid', 10);
			}
			$update['birthday'] = date('Y-m-d', $birthday);
			unset($values['birthday']);
		}
		if (array_key_exists('pays', $values))
		{
			$update['pays'] = trim($values['pays']);
			unset($values['pays']);
		}
		if (array_key_exists('code_postal', $values))
		{
		    $cp = trim($values['code_postal']);
		    if ( !is_numeric($cp) )
		    {
		    	throw new \SimpleUserUpdateException('Code postal is not valid', 11);
		    }
			$update['code_postal'] = $cp;
			unset($values['code_postal']);
		}
		if (array_key_exists('notif', $values))
		{
			$update['notif'] = trim($values['notif']);
			unset($values['notif']);
		}
		if (array_key_exists('sns_links', $values))
		{
			$update['sns_links'] = trim($values['sns_links']);
			unset($values['sns_links']);
		}
		if ( ! empty($values))
		{
			$profile_fields = @unserialize($current_values->get('profile_fields')) ?: array();
			foreach ($values as $key => $val)
			{
				if ($val === null)
				{
					unset($profile_fields[$key]);
				}
				else
				{
					$profile_fields[$key] = $val;
				}
			}
			$update['profile_fields'] = serialize($profile_fields);
		}

		$affected_rows = \DB::update(\Config::get('simpleauth.table_name'))
			->set($update)
			->where('pseudo', '=', $pseudo)
			->execute(\Config::get('simpleauth.db_connection'));

		// Refresh user
		if ($this->user['pseudo'] == $pseudo)
		{
			$this->user = \DB::select_array(\Config::get('simpleauth.table_columns', array('*')))
				->where('pseudo', '=', $pseudo)
				->from(\Config::get('simpleauth.table_name'))
				->execute(\Config::get('simpleauth.db_connection'))->current();
		}

		return $affected_rows > 0;
	}

	/**
	 * Change a user's password
	 *
	 * @param   string
	 * @param   string
	 * @param   string  pseudo or null for current user
	 * @return  bool
	 */
	public function change_password($old_password, $new_password, $pseudo = null)
	{
		try
		{
			return (bool) $this->update_user(array('old_password' => $old_password, 'password' => $new_password), $pseudo);
		}
		// Only catch the wrong password exception
		catch (SimpleUserWrongPassword $e)
		{
			return false;
		}
	}

	/**
	 * Generates new random password, sets it for the given pseudo and returns the new password.
	 * To be used for resetting a user's forgotten password, should be emailed afterwards.
	 *
	 * @param   string  $pseudo
	 * @return  string
	 */
	public function reset_password($email)
	{
		$new_password = \Str::random('alnum', 8);
		$password_hash = $this->hash_password($new_password);

		$affected_rows = \DB::update(\Config::get('simpleauth.table_name'))
			->set(array('password' => $password_hash))
			->or_where('email', '=', $email)
			->execute(\Config::get('simpleauth.db_connection'));

		if ( ! $affected_rows)
		{
			throw new \SimpleUserUpdateException('Failed to reset password, user was invalid.', 8);
		}

		return $new_password;
	}

	/**
	 * Deletes a given user
	 *
	 * @param   string
	 * @return  bool
	 */
	public function delete_user($pseudo)
	{
		if (empty($pseudo))
		{
			throw new \SimpleUserUpdateException('Cannot delete user with empty pseudo', 9);
		}

		$affected_rows = \DB::delete(\Config::get('simpleauth.table_name'))
			->where('pseudo', '=', $pseudo)
			->execute(\Config::get('simpleauth.db_connection'));

		return $affected_rows > 0;
	}

	/**
	 * Creates a temporary hash that will validate the current login
	 *
	 * @return  string
	 */
	public function create_login_hash()
	{
		if (empty($this->user))
		{
			throw new \SimpleUserUpdateException('User not logged in, can\'t create login hash.', 10);
		}

		$updated_at = \Date::forge()->get_timestamp();
		$login_hash = sha1(\Config::get('simpleauth.login_hash_salt').$this->user['pseudo'].$updated_at);

		\DB::update(\Config::get('simpleauth.table_name'))
			->set(array('updated_at' => $updated_at, 'login_hash' => $login_hash))
			->where('pseudo', '=', $this->user['pseudo'])
			->execute(\Config::get('simpleauth.db_connection'));

		$this->user['login_hash'] = $login_hash;

		return $login_hash;
	}

	/**
	 * Get the user's ID
	 *
	 * @return  Array  containing this driver's ID & the user's ID
	 */
	public function get_user_id()
	{
		if (empty($this->user))
		{
			return false;
		}

		return array($this->id, (int) $this->user['id']);
	}

	/**
	 * Get the user's groups
	 *
	 * @return  Array  containing the group driver ID & the user's group ID
	 */
	public function get_groups()
	{
		if (empty($this->user))
		{
			return false;
		}

		return array(array('SimpleGroup', $this->user['group']));
	}

	/**
	 * Get the user's emailaddress
	 *
	 * @return  string
	 */
	public function get_email()
	{
		if (empty($this->user))
		{
			return false;
		}

		return $this->user['email'];
	}

	/**
	 * Get the user's screen name
	 *
	 * @return  string
	 */
	public function get_screen_name()
	{
		if (empty($this->user))
		{
			return false;
		}

		return $this->user['pseudo'];
	}

	/**
	 * Get the user's profile fields
	 *
	 * @return  Array
	 */
	public function get_profile_fields($field = null, $default = null)
	{
		if (empty($this->user))
		{
			return false;
		}

		if (isset($this->user['profile_fields']))
		{
			is_array($this->user['profile_fields']) or $this->user['profile_fields'] = @unserialize($this->user['profile_fields']);
		}
		else
		{
			$this->user['profile_fields'] = array();
		}

		return is_null($field) ? $this->user['profile_fields'] : \Arr::get($this->user['profile_fields'], $field, $default);
	}

	/**
	 * Extension of base driver method to default to user group instead of user id
	 */
	public function has_access($condition, $driver = null, $user = null)
	{
		if (is_null($user))
		{
			$groups = $this->get_groups();
			$user = reset($groups);
		}
		return parent::has_access($condition, $driver, $user);
	}

	/**
	 * Extension of base driver because this supports a guest login when switched on
	 */
	public function guest_login()
	{
		return \Config::get('simpleauth.guest_login', true);
	}
}

// end of file simpleauth.php
