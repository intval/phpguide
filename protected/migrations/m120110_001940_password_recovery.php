<?php

class m120110_001940_password_recovery extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('password_recovery', array(
				'id' => 'pk',
				'userid' => 'bigint(20) unsigned',
				'key' => 'varchar(20) not null',
				'validity' => 'datetime not null',
				'ip' => 'varchar(32) not null'
				));
		
		$this->addForeignKey('user2users', 'password_recovery', 'userid', 'users', 'id');
	}


	public function safeDown()
	{
		$this->dropTable('password_recovery');
	}
	
}