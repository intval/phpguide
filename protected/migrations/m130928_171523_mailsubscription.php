<?php

class m130928_171523_mailsubscription extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->addColumn(User::model()->tableName(), 'hasMailSubscription', 'boolean');
	}

	public function safeDown()
	{
        $this->dropColumn(User::model()->tableName(), 'hasMailSubscription');
	}

}