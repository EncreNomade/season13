<?php

namespace Fuel\Migrations;

class Create_user_gameinfos
{
	public function up()
	{
		\DBUtil::create_table('user_gameinfos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'game_id' => array('constraint' => 11, 'type' => 'int'),
			'bestScore' => array('constraint' => 255, 'type' => 'varchar'),
			'retry_number' => array('constraint' => 3, 'type' => 'int'),
			'supp' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('user_gameinfos');
	}
}