<?php

namespace Fuel\Migrations;

class Create_achat_payzenchecks
{
	public function up()
	{
		\DBUtil::create_table('achat_payzenchecks', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'vads_trans_id' => array('constraint' => 6, 'type' => 'varchar'),
			'vads_result' => array('constraint' => 6, 'type' => 'varchar'),
			'vads_trans_status' => array('constraint' => 32, 'type' => 'varchar'),
			'vads_auth_mode' => array('constraint' => 16, 'type' => 'varchar'),
			'signature' => array('constraint' => 32, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('achat_payzenchecks');
	}
}