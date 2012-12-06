<?php

namespace Fuel\Migrations;

class Create_webservice_plateformapps
{
	public function up()
	{
		\DBUtil::create_table('webservice_plateformapps', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'appid' => array('constraint' => 32, 'type' => 'varchar'),
			'appsecret' => array('constraint' => 32, 'type' => 'varchar'),
			'appname' => array('constraint' => 32, 'type' => 'varchar'),
			'description' => array('constraint' => 255, 'type' => 'varchar'),
			'active' => array('constraint' => 1, 'type' => 'int'),
			'ip' => array('constraint' => 40, 'type' => 'varchar'),
			'host' => array('constraint' => 255, 'type' => 'varchar'),
			'extra' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('webservice_plateformapps');
	}
}