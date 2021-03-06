<?php
use Orm\Model;

class Model_User_Address extends Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'firstname',
		'lastname',
		'address',
		'email',
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
		$val->add_field('firstname', 'ton prénom', 'max_length[32]');
		$val->add_field('lastname', 'ton nom', 'required|max_length[32]');
		$val->add_field('email', 'ton adresse mail', 'required|valid_email');
		$val->add_field('address', 'ton adresse', 'required|max_length[255]');
		$val->add_field('postcode', 'ton code postal', 'required|max_length[12]');
		$val->add_field('city', 'ta ville', 'required|max_length[64]');
		$val->add_field('country_code', 'ton pays', 'required|max_length[2]');
		$val->add_field('tel', 'ton numéro de téléphone', 'max_length[16]');
		$val->add_field('title', 'Title', 'max_length[32]');
		$val->add_field('supp', 'Supp', 'max_length[255]');

		return $val;
	}
	
	public static function getUserAdress($user_id) {
		if(is_null($user_id))
			return null;

		$user_address = self::find_by_user_id($user_id);
		if(is_null($user_address))
			return null;
		else
			return $user_address;
	}

}
