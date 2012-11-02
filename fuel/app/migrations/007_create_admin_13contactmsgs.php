<?php

namespace Fuel\Migrations;

class Create_admin_13contactmsgs
{
	public function up()
	{
		\DBUtil::create_table('admin_13contactmsgs', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'nom' => array('constraint' => 32, 'type' => 'varchar'),
			'user' => array('constraint' => 11, 'type' => 'int'),
			'email' => array('constraint' => 255, 'type' => 'varchar'),
			'destination' => array('constraint' => 255, 'type' => 'varchar'),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'message' => array('type' => 'text'),
			'response' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('admin_13contactmsgs');
	}
}