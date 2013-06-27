<?php

class Model_Achat_Payzencheck extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'order_ref',
		'vads_trans_id',
		'vads_result',
		'vads_trans_status',
		'vads_auth_mode',
		'signature',
		'params',
		'created_at',
		'updated_at'
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
