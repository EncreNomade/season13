<?php
use Orm\Model;

class Model_Admin_13post extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'slug',
		'user_id',
		'summary',
		'body',
		'categories',
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
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('slug', 'Slug', 'required|max_length[255]');
		$val->add_field('user_id', 'User Id', 'required|valid_string[numeric]');
		$val->add_field('summary', 'Summary', 'required');
		$val->add_field('body', 'Body', 'required');
		$val->add_field('categories', 'Categories', 'required|max_length[255]');

		return $val;
	}

}
