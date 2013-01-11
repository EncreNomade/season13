<?php

namespace Fuel\Migrations;

class Create_achat_countries
{
	public function up()
	{
		\DBUtil::create_table('achat_countries', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 64, 'type' => 'varchar'),
			'iso_code' => array('constraint' => 3, 'type' => 'varchar'),
			'language' => array('constraint' => 16, 'type' => 'varchar'),
			'tax_rate' => array('constraint' => '4,2', 'type' => 'decimal'),
			'currency_code' => array('constraint' => 3, 'type' => 'varchar'),
			'active' => array('constraint' => 1, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('achat_countries');
	}
}