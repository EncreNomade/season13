<?php

namespace Fuel\Migrations;

class Create_book_13books
{
	public function up()
	{
		\DBUtil::create_table('book_13books', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'reference' => array('constraint' => 32, 'type' => 'varchar'),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'sub_title' => array('constraint' => 255, 'type' => 'varchar'),
			'cover' => array('constraint' => 255, 'type' => 'varchar'),
			'author_id' => array('constraint' => 11, 'type' => 'int'),
			'brief' => array('type' => 'text'),
			'tags' => array('constraint' => 255, 'type' => 'varchar'),
			'categories' => array('constraint' => 255, 'type' => 'varchar'),
			'extra_info' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('book_13books');
	}
}