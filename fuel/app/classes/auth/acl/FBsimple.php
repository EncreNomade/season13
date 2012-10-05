<?php
class Auth_Acl_FBacl extends Auth\Auth_Acl_SimpleAcl
{

	protected static $_valid_roles = array();

	public static function _init()
	{
		static::$_valid_roles = array_keys(\Config::get('fbauth.roles'));
	}

}

