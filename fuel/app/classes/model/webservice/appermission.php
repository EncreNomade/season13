<?php
use Orm\Model;

class Model_Webservice_Appermission extends Model
{
	protected static $_properties = array(
		'id',
		'appid',
		'action',
		'can_get',
		'can_post',
		'can_put',
		'can_delete',
		'created_at',
		'updated_at',
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
		$val->add_field('appid', 'Appid', 'required');
		$val->add_field('action', 'Action', 'required');
		$val->add_field('can_get', 'Can Get', 'required|valid_string[numeric]');
		$val->add_field('can_post', 'Can Post', 'required|valid_string[numeric]');
		$val->add_field('can_put', 'Can Put', 'required|valid_string[numeric]');
		$val->add_field('can_delete', 'Can Delete', 'required|valid_string[numeric]');

		return $val;
	}

}
