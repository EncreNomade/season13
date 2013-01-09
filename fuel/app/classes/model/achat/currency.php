<?php
use Orm\Model;

class Model_Achat_Currency extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'iso_code',
		'iso_code_num',
		'sign',
		'active',
		'conversion_rate',
		'supp',
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
		$val->add_field('name', 'Name', 'required|max_length[32]');
		$val->add_field('iso_code', 'Iso Code', 'required|max_length[3]');
		$val->add_field('iso_code_num', 'Iso Code Num', 'required|max_length[3]');
		$val->add_field('sign', 'Sign', 'required|max_length[8]');
		$val->add_field('active', 'Active', 'required|valid_string[numeric]');
		$val->add_field('conversion_rate', 'Conversion Rate', 'required');
		$val->add_field('supp', 'Supp', 'required|max_length[255]');

		return $val;
	}

}
