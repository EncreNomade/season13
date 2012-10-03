<?php

namespace Fuel\Migrations;

class Create_13users
{
	public function up()
	{
		\DBUtil::create_table('13users', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'pseudo' => array('constraint' => 50, 'type' => 'varchar'),
			'password' => array('constraint' => 255, 'type' => 'varchar'),
			'group' => array('constraint' => 11, 'type' => 'int'),
			'email' => array('constraint' => 255, 'type' => 'varchar'),
			'portable' => array('constraint' => 30, 'type' => 'varchar'),
			'avatar' => array('constraint' => 255, 'type' => 'varchar'),
			'sex' => array('constraint' => 1, 'type' => 'varchar'),
			'birthday' => array('type' => 'date'),
			'notif' => array('constraint' => 16, 'type' => 'varchar'),
			'fbid' => array('constraint' => 32, 'type' => 'int'),
			'profile_fields' => array('type' => 'text'),
			'sns_links' => array('type' => 'text'),
			'login_hash' => array('constraint' => 255, 'type' => 'varchar'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('13users');
	}
}