<?php

namespace Fuel\Migrations;

class Create_admin_13userpossesions
{
	public function up()
	{
		\DBUtil::create_table('admin_13userpossesions', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user_mail' => array('constraint' => 255, 'type' => 'varchar'),
			'episode_id' => array('constraint' => 11, 'type' => 'int'),
			'source' => array('constraint' => 11, 'type' => 'int'),
			'source_ref' => array('constraint' => 32, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('admin_13userpossesions');
	}
}