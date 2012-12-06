<?php

namespace Fuel\Migrations;

class Create_webservice_appermissions
{
	public function up()
	{
		\DBUtil::create_table('webservice_appermissions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'appid' => array('constraint' => 32, 'type' => 'varchar'),
			'action' => array('constraint' => 24, 'type' => 'varchar'),
			'can_get' => array('constraint' => 1, 'type' => 'int'),
			'can_post' => array('constraint' => 1, 'type' => 'int'),
			'can_put' => array('constraint' => 1, 'type' => 'int'),
			'can_delete' => array('constraint' => 1, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('webservice_appermissions');
	}
}