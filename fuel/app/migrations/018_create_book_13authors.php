<?php

namespace Fuel\Migrations;

class Create_book_13authors
{
	public function up()
	{
		\DBUtil::create_table('book_13authors', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'firstname' => array('constraint' => 32, 'type' => 'varchar'),
			'lastname' => array('constraint' => 32, 'type' => 'varchar'),
			'nickname' => array('constraint' => 32, 'type' => 'varchar'),
			'biographie' => array('type' => 'text'),
			'photo' => array('constraint' => 255, 'type' => 'varchar'),
			'author_slogan' => array('type' => 'text'),
			'metas' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('book_13authors');
	}
}