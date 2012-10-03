<?php

namespace Fuel\Migrations;

class Create_admin_13episodes
{
	public function up()
	{
		\DBUtil::create_table('admin_13episodes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'story' => array('constraint' => 255, 'type' => 'varchar'),
			'season' => array('constraint' => 11, 'type' => 'int'),
			'episode' => array('constraint' => 11, 'type' => 'int'),
			'path' => array('constraint' => 255, 'type' => 'varchar'),
			'bref' => array('type' => 'text'),
			'image' => array('constraint' => 255, 'type' => 'varchar'),
			'dday' => array('type' => 'date'),
			'price' => array('constraint' => 10, 'type' => 'varchar'),
			'info_supp' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('admin_13episodes');
	}
}