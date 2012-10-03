<?php

namespace Fuel\Migrations;

class Create_admin_13posts
{
	public function up()
	{
		\DBUtil::create_table('admin_13posts', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'slug' => array('constraint' => 255, 'type' => 'varchar'),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'summary' => array('type' => 'text'),
			'body' => array('type' => 'text'),
			'categories' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('admin_13posts');
	}
}