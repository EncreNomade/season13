<?php

class Model_Achat_Cartproduct extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'cart_id',
		'cart_product_id',
		'product_id',
		'product_title',
		'taxed_price',
		'discount',
		'offer',
		'offer_target',
		'created_at',
		'updated_at'
	);

	protected static $_belongs_to = array(
	    'product' => array(
	        'key_from' => 'product_id',
	        'model_to' => 'Model_Achat_13product',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	    )
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
	
	public function getRealPrice() {
	    return round($this->discount * $this->taxed_price, 2);
	}
}
