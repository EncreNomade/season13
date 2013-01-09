<?php

class Model_Achat_Order extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'user_addr',
		'cart_id',
		'country_code',
		'state',
		,
		,
		,
		'secure_key',
		'payment',
		'total_paid_taxed',
		'currency_code'
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
}
