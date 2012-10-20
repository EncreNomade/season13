<?php
use Orm\Model;

class Model_Admin_13comment extends Model
{
	protected static $_properties = array(
		'id',
		'user',
		'content',
		'image',
		'fbpostid',
		'position',
		'verified',
		'epid',
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
		$val->add_field('user', 'User', 'required|valid_string[numeric]');
		$val->add_field('content', 'Content', 'required');
		$val->add_field('image', 'Image', 'required|max_length[255]');
		$val->add_field('fbpostid', 'Fbpostid', 'required|max_length[255]');
		$val->add_field('position', 'Position', 'required|max_length[255]');
		$val->add_field('verified', 'Verified', 'required');
		$val->add_field('epid', 'Epid', 'required|valid_string[numeric]');

		return $val;
	}

}
