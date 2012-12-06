<?php

class Model_Webservice_Requestrecord extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'appid',
		'service_requested',
		'params',
		'token',
		'extra'
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
