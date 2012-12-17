<?php
use Orm\Model;

class Model_Book_13season extends Model
{
	protected static $_properties = array(
		'id',
		'reference',
		'book_id',
		'season_id',
		'title',
		'cover',
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
		$val->add_field('reference', 'Reference', 'max_length[32]');
		$val->add_field('book_id', 'Book Id', 'required|valid_string[numeric]');
		$val->add_field('season_id', 'Season Id', 'required|valid_string[numeric]');
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('cover', 'Cover', 'required|max_length[255]');
		//$val->add_field('extra_info', 'Extra Info', 'required');

		return $val;
	}

}
