<?php
use Orm\Model;

class Model_Admin_13episode extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'story',
		'season',
		'episode',
		'path',
		'bref',
		'image',
		'dday',
		'price',
		'info_supp',
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
		$val->add_field('story', 'Story', 'required|max_length[255]');
		$val->add_field('season', 'Season', 'required|valid_string[numeric]');
		$val->add_field('episode', 'Episode', 'required|valid_string[numeric]');
		$val->add_field('path', 'Path', 'required|max_length[255]');
		$val->add_field('bref', 'Bref', 'required');
		$val->add_field('image', 'Image', 'required|max_length[255]');
		$val->add_field('dday', 'Dday', 'required');
		$val->add_field('price', 'Price', 'required|max_length[10]');
		$val->add_field('info_supp', 'Info Supp', 'required');

		return $val;
	}

}
