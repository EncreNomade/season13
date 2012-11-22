<?php

namespace Fuel\Migrations;

class Create_admin_13userpossesions
{
	public function up()
	{
		\DBUtil::create_table('admin_13userpossesions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'episode_id' => array('constraint' => 11, 'type' => 'int'),
			'source' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('admin_13userpossesions');
	}
}