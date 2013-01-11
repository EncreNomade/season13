<?php

namespace Fuel\Migrations;

class Create_achat_cartproducts
{
	public function up()
	{
		\DBUtil::create_table('achat_cartproducts', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'cart_id' => array('constraint' => 11, 'type' => 'int'),
			'product_id' => array('constraint' => 11, 'type' => 'int'),
			'product_title' => array('constraint' => 255, 'type' => 'varchar'),
			'taxed_price' => array('constraint' => '8,2', 'type' => 'decimal'),
			'discount' => array('constraint' => '3,2', 'type' => 'decimal'),
			'offer' => array('constraint' => 1, 'type' => 'int'),
			'offer_target' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('achat_cartproducts');
	}
}