<?php

class m121116_184205_is_correct_default_value extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->alterColumn('qna_answers', 'is_correct', 'TINYINT DEFAULT 0');
	}

	public function safeDown()
	{
	}

}