<?php

class m121118_165027_subscription_ip extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $tbl = QnaSubscription::model()->tableName();
        $this->addColumn($tbl, 'ip', 'string');
        $this->addColumn($tbl, 'time', 'datetime');
	}

	public function safeDown()
	{
        $tbl = QnaSubscription::model()->tableName();
        $this->dropColumn($tbl, 'ip');
        $this->dropColumn($tbl, 'time');
	}

}