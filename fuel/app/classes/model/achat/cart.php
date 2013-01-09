<?php

class Model_Achat_Cart extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'user_id',
		'secure_key',
		'tax_rate',
		'country_code',
		'currency_code',
		'conversion_rate',
		'ordered',
		'supp'
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
