<?php

class Model_Achat_Cartproduct extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'cart_id',
		'product_id',
		'taxed_price',
		'discount',
		'offer',
		'offer_target'
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
