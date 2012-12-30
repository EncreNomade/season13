<?php

namespace Fuel\Migrations;

class Create_webservice_requestrecords
{
	public function up()
	{
		\DBUtil::create_table('webservice_requestrecords', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'appid' => array('constraint' => 32, 'type' => 'varchar'),
			'service_requested' => array('constraint' => 32, 'type' => 'varchar'),
			'params' => array('constraint' => 255, 'type' => 'varchar'),
			'token' => array('constraint' => 32, 'type' => 'varchar'),
			'extra' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('webservice_requestrecords');
	}
}