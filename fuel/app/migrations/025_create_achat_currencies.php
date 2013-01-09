<?php

namespace Fuel\Migrations;

class Create_achat_currencies
{
	public function up()
	{
		\DBUtil::create_table('achat_currencies', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 32, 'type' => 'varchar'),
			'iso_code' => array('constraint' => 3, 'type' => 'varchar'),
			'iso_code_num' => array('constraint' => 3, 'type' => 'varchar'),
			'sign' => array('constraint' => 8, 'type' => 'varchar'),
			'active' => array('constraint' => 1, 'type' => 'int'),
			'conversion_rate' => array('constraint' => '13,6', 'type' => 'decimal'),
			'supp' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('achat_currencies');
	}
}