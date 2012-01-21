<?php

class m120121_142901_last_login2last_visit extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->renameColumn('users', 'last_login', 'last_visit');
	}

	public function safeDown()
	{
		$this->renameColumn('users', 'last_visit', 'last_login');
	}
	
}