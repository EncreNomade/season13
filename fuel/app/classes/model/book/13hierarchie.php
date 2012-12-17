<?php
use Orm\Model;

class Model_Book_13hierarchie extends Model
{
	protected static $_properties = array(
		'id',
		'epid',
		'belongto',
		'relation_type',
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
		$val->add_field('epid', 'Epid', 'required|valid_string[numeric]');
		$val->add_field('belongto', 'Belongto', 'required|valid_string[numeric]');
		$val->add_field('relation_type', 'Relation Type', 'valid_string[numeric]');
		$val->add_field('extra', 'Extra', 'max_length[255]');

		return $val;
	}

}
