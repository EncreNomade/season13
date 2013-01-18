<?php

namespace Fuel\Migrations;

class Create_user_episodeinfos
{
	public function up()
	{
		\DBUtil::create_table('user_episodeinfos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'episode_id' => array('constraint' => 11, 'type' => 'int'),
			'position' => array('constraint' => 255, 'type' => 'varchar'),
			'started' => array('constraint' => 1, 'type' => 'int'),
			'completed' => array('constraint' => 1, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('user_episodeinfos');
	}
}