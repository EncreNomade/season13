<?php

namespace Fuel\Migrations;

class Create_achat_carts
{
	public function up()
	{
		\DBUtil::create_table('achat_carts', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'secure_key' => array('constraint' => 32, 'type' => 'varchar'),
			'tax_rate' => array('constraint' => '4,2', 'type' => 'decimal'),
			'country_code' => array('constraint' => 2, 'type' => 'varchar'),
			'currency_code' => array('constraint' => 3, 'type' => 'varchar'),
			'conversion_rate' => array('constraint' => '13,6', 'type' => 'decimal'),
			'ordered' => array('constraint' => 1, 'type' => 'int'),
			'supp' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('achat_carts');
	}
}