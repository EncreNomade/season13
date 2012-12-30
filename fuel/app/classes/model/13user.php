<?php

class Model_13user extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'pseudo',
		'password',
		'group',
		'email',
		'portable',
		'avatar',
		'sex',
		'birthday',
		'pays',
		'code_postal',
		'notif',
		'fbid',
		'profile_fields',
		'sns_links',
		'login_hash',
		'created_at',
		'updated_at'
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('pseudo', 'Pseudo', 'required');
		$val->add_field('group', 'Group', 'required|valid_string[numeric]');
		$val->add_field('email', 'Email', 'required|valid_email');
		$val->add_field('avatar', 'Avatar', 'required');
		$val->add_field('sex', 'Gender', 'required');
		$val->add_field('birthday', 'Birthday', 'required');

		return $val;
	}
}
