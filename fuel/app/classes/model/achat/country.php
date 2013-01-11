<?php
use Orm\Model;

class Model_Achat_Country extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'iso_code',
		'language',
		'tax_rate',
		'currency_code',
		'active',
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

	// a country should have only one currency
	protected static $_belongs_to = array(
		'currency' => array(
			'key_from' => 'currency_code',
			'model_to' => 'Model_Achat_Currency',
			'key_to' => 'iso_code',
			'cascade_save' => true,
			'cascade_delete' => false,
		)
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[64]');
		$val->add_field('iso_code', 'Iso Code', 'required|max_length[3]');
		$val->add_field('language', 'Language', 'required|max_length[16]');
		$val->add_field('tax_rate', 'Tax Rate', 'required');
		$val->add_field('currency_code', 'Currency Code', 'required|max_length[3]');
		$val->add_field('active', 'Active', 'required|valid_string[numeric]');

		return $val;
	}

	public static function getWithCurrency($countryCode = '') 
	{
		return self::query()->related('currency', array('join_type' => 'inner'))->where('iso_code', $countryCode)->get_one();
	}

}
