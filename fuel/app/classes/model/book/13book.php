<?php
use Orm\Model;

class Model_Book_13book extends Model
{
	protected static $_properties = array(
		'id',
		'reference',
		'title',
		'sub_title',
		'cover',
		'author_id',
		'brief',
		'tags',
		'categories',
		'extra_info',
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
		$val->add_field('reference', 'Reference', 'required|max_length[32]');
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('sub_title', 'Sub Title', 'max_length[255]');
		$val->add_field('cover', 'Cover', 'required|max_length[255]');
		$val->add_field('author_id', 'Author Id', 'required|valid_string[numeric]');
		//$val->add_field('brief', 'Brief', 'required');
		$val->add_field('tags', 'Tags', 'max_length[255]');
		$val->add_field('categories', 'Categories', 'max_length[255]');
		//$val->add_field('extra_info', 'Extra Info', 'required');

		return $val;
	}

}
