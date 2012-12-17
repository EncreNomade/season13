<?php

namespace Fuel\Migrations;

class Create_book_13seasons
{
	public function up()
	{
		\DBUtil::create_table('book_13seasons', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'reference' => array('constraint' => 32, 'type' => 'varchar'),
			'book_id' => array('constraint' => 11, 'type' => 'int'),
			'season_id' => array('constraint' => 3, 'type' => 'int'),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'cover' => array('constraint' => 255, 'type' => 'varchar'),
			'extra_info' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('book_13seasons');
	}
}