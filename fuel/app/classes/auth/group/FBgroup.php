<?php

class Auth_Group_FBgroup extends Auth\Auth_Group_SimpleGroup {
    public static $_valid_groups = array();

	public static function _init()
	{
		static::$_valid_groups = array_keys(\Config::get('fbauth.groups'));
	}
}