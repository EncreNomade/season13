<?php
use Orm\Model;

class Model_User_Address extends Model
{
	protected static $_properties = array(
		'id',
		'firstname',
		'lastname',
		'address',
		'postcode',
		'city',
		'country_code',
		'tel',
		'title',
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
		$val->add_field('firstname', 'Firstname', 'required|max_length[32]');
		$val->add_field('lastname', 'Lastname', 'required|max_length[32]');
		$val->add_field('address', 'Address', 'required|max_length[255]');
		$val->add_field('postcode', 'Postcode', 'required|max_length[12]');
		$val->add_field('city', 'City', 'required|max_length[64]');
		$val->add_field('country_code', 'Country Code', 'required|max_length[2]');
		$val->add_field('tel', 'Tel', 'required|max_length[16]');
		$val->add_field('title', 'Title', 'max_length[32]');
		$val->add_field('supp', 'Supp', 'max_length[255]');

		return $val;
	}

}
