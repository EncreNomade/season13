<?php
use Orm\Model;

class Model_Achat_13extorder extends Model
{
	protected static $_properties = array(
		'id',
		'reference',
		'owner',
		'order_source',
		'appid',
		'price',
		'app_name',
		'state',
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
		$val->add_field('reference', 'Reference', 'required');
		$val->add_field('owner', 'Owner', 'required|valid_email');
		$val->add_field('order_source', 'Order Source', 'max_length[255]');
		$val->add_field('appid', 'Appid', 'required');
		$val->add_field('price', 'Price', 'required');

		return $val;
	}

}
