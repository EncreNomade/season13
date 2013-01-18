<?php

namespace Fuel\Migrations;

class Create_achat_orders
{
	public function up()
	{
		\DBUtil::create_table('achat_orders', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'user_addr' => array('constraint' => 11, 'type' => 'int'),
			'cart_id' => array('constraint' => 11, 'type' => 'int'),
			'country_code' => array('constraint' => 2, 'type' => 'varchar'),
			'state' => array('constraint' => '"ORDER","CANCEL","FINALIZE","RETURN","FAIL","STARTPAY"', 'type' => 'enum'),
			'secure_key' => array('constraint' => 32, 'type' => 'varchar'),
			'payment' => array('constraint' => 10, 'type' => 'varchar'),
			'total_paid_taxed' => array('constraint' => '8,2', 'type' => 'decimal'),
			'currency_code' => array('constraint' => 3, 'type' => 'varchar'),
			'transaction_infos' => array('type' => 'text'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('achat_orders');
	}
}