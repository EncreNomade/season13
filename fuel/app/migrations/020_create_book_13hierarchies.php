<?php

namespace Fuel\Migrations;

class Create_book_13hierarchies
{
	public function up()
	{
		\DBUtil::create_table('book_13hierarchies', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'epid' => array('constraint' => 11, 'type' => 'int'),
			'belongto' => array('constraint' => 11, 'type' => 'int'),
			'relation_type' => array('constraint' => 2, 'type' => 'int'),
			'extra' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('book_13hierarchies');
	}
}