<?php

namespace Fuel\Migrations;

class Create_achat_13products
{
	public function up()
	{
		\DBUtil::create_table('achat_13products', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'reference' => array('constraint' => 32, 'type' => 'varchar'),
			'type' => array('constraint' => '"book","season","episode"', 'type' => 'enum'),
			'pack' => array('constraint' => 1, 'type' => 'int'),
			'content' => array('type' => 'text'),
			'presentation' => array('type' => 'text'),
			'tags' => array('constraint' => 255, 'type' => 'varchar'),
			'title' => array('constraint' => 255, 'type' => 'varchar'),
			'category' => array('constraint' => 64, 'type' => 'varchar'),
			'metas' => array('type' => 'text'),
			'on_sale' => array('constraint' => 1, 'type' => 'int'),
			'price' => array('constraint' => '20,6', 'type' => 'decimal'),
			'discount' => array('constraint' => '3,2', 'type' => 'decimal'),
			'sales' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('achat_13products');
	}
}