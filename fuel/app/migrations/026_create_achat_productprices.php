<?php

namespace Fuel\Migrations;

class Create_achat_productprices
{
	public function up()
	{
		\DBUtil::create_table('achat_productprices', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'product_id' => array('constraint' => 11, 'type' => 'int'),
			'country_code' => array('constraint' => 3, 'type' => 'varchar'),
			'taxed_price' => array('constraint' => '8,2', 'type' => 'decimal'),
			'discount' => array('constraint' => '3,2', 'type' => 'decimal'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('achat_productprices');
	}
}