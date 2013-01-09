<?php

namespace Fuel\Migrations;

class Create_user_addresses
{
	public function up()
	{
		\DBUtil::create_table('user_addresses', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'firstname' => array('constraint' => 32, 'type' => 'varchar'),
			'lastname' => array('constraint' => 32, 'type' => 'varchar'),
			'address' => array('constraint' => 255, 'type' => 'varchar'),
			'postcode' => array('constraint' => 12, 'type' => 'varchar'),
			'city' => array('constraint' => 64, 'type' => 'varchar'),
			'country_code' => array('constraint' => 2, 'type' => 'varchar'),
			'tel' => array('constraint' => 16, 'type' => 'varchar'),
			'title' => array('constraint' => 32, 'type' => 'varchar'),
			'supp' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('user_addresses');
	}
}