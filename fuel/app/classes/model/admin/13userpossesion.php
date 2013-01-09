<?php
use Orm\Model;

class Model_Admin_13userpossesion extends Model
{
	protected static $_properties = array(
		'id',
		'user_mail',
		'episode_id',
		'source',
		'source_ref',
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
		$val->add_field('user_mail', 'User Mail', 'required|valid_email');
		$val->add_field('episode_id', 'Episode Id', 'required|valid_string[numeric]');
		$val->add_field('source', 'Source', 'required|valid_string[numeric]');

		return $val;
	}

}
