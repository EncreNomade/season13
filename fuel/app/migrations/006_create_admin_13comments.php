<?php

namespace Fuel\Migrations;

class Create_admin_13comments
{
	public function up()
	{
		\DBUtil::create_table('admin_13comments', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user' => array('constraint' => 11, 'type' => 'int'),
			'content' => array('type' => 'text'),
			'image' => array('constraint' => 255, 'type' => 'varchar'),
			'fbpostid' => array('constraint' => 255, 'type' => 'varchar'),
			'position' => array('constraint' => 255, 'type' => 'varchar'),
			'verified' => array('type' => 'bool'),
			'epid' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('admin_13comments');
	}
}