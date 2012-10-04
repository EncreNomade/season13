<?php

namespace Fuel\Migrations;

class Create_uploads
{
	public function up()
	{
		\DBUtil::create_table('uploads', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 64, 'type' => 'varchar'),
			'type' => array('constraint' => 16, 'type' => 'varchar'),
			'path' => array('constraint' => 255, 'type' => 'varchar'),
			'access' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('uploads');
	}
}