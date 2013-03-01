<?php

namespace Fuel\Migrations;

class Create_admin_tasks
{
	public function up()
	{
		\DBUtil::create_table('admin_tasks', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'creator' => array('constraint' => 11, 'type' => 'int'),
			'type' => array('constraint' => 64, 'type' => 'varchar'),
			'parameters' => array('type' => 'text'),
			'whentodo' => array('constraint' => 64, 'type' => 'varchar'),
			'done' => array('constraint' => 1, 'type' => 'int'),
			'whendone' => array('type' => 'timestamp'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('admin_tasks');
	}
}