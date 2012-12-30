<?php

namespace Fuel\Migrations;

class Create_achat_13extorders
{
	public function up()
	{
		\DBUtil::create_table('achat_13extorders', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'reference' => array('constraint' => 32, 'type' => 'varchar'),
			'owner' => array('constraint' => 255, 'type' => 'varchar'),
			'order_source' => array('constraint' => 255, 'type' => 'varchar'),
			'appid' => array('constraint' => 32, 'type' => 'varchar'),
			'price' => array('constraint' => '20,6', 'type' => 'decimal'),
			'app_name' => array('constraint' => 32, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('achat_13extorders');
	}
}