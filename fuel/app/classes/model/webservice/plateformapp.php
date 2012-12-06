<?php
use Orm\Model;

class Model_Webservice_Plateformapp extends Model
{
	protected static $_properties = array(
		'id',
		'appid',
		'appsecret',
		'appname',
		'description',
		'active',
		'ip',
		'host',
		'extra',
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
		$val->add_field('appsecret', 'Appsecret', 'required');
		$val->add_field('appname', 'Appname', 'required');
		$val->add_field('description', 'Description', 'required|max_length[255]');
		$val->add_field('active', 'Active', 'required|valid_string[numeric]');
		$val->add_field('ip', 'Ip', 'required');
		$val->add_field('host', 'Host', 'required|max_length[255]');
		$val->add_field('extra', 'Extra', 'required');

		return $val;
	}

}
