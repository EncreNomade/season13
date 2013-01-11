<?php
use Orm\Model;

class Model_Achat_Productprice extends Model
{
	protected static $_properties = array(
		'id',
		'product_id',
		'country_code',
		'taxed_price',
		'discount',
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
		$val->add_field('product_id', 'Product Id', 'required|valid_string[numeric]');
		$val->add_field('country_code', 'Country Code', 'required|max_length[3]');
		$val->add_field('taxed_price', 'Taxed Price', 'required');
		$val->add_field('discount', 'Discount', 'required');

		return $val;
	}

	public static function find_by_id_and_country($product = "", $country = "")
	{
		$obj = self::find('first', array(
			"where" => array(
				array("product_id" => $product),
				array("country_code" => $country)
			)
		));

		return $obj;
	}

}
