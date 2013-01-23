<?php

namespace Fuel\Migrations;

class Create_book_13games
{
	public function up()
	{
		\DBUtil::create_table('book_13games', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 64, 'type' => 'varchar'),
			'epid' => array('constraint' => 11, 'type' => 'int'),
			'expo' => array('constraint' => 255, 'type' => 'varchar'),
			'instruction' => array('type' => 'text'),
			'presentation' => array('type' => 'text'),
			'categories' => array('constraint' => 255, 'type' => 'varchar'),
			'metas' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),			
			'class_name' => array('constraint' => 255, 'type' => 'varchar'),
			'path' => array('type' => 'text'),
			'file_name' => array('type' => 'text')

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('book_13games');
	}
}