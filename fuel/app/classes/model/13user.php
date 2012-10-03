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
}
