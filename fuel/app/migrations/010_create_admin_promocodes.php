<?php

namespace Fuel\Migrations;

class Create_admin_promocodes
{
	public function up()
	{
		\DBUtil::create_table('admin_promocodes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'code' => array('constraint' => 32, 'type' => 'varchar'),
			'used' => array('constraint' => 1, 'type' => 'int'),
			'used_by' => array('constraint' => 11, 'type' => 'int'),
			'offer' => array('type' => 'text'),
			'ref' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('admin_promocodes');
	}
}