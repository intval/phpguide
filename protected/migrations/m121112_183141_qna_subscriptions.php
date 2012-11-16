<?php

class m121112_183141_qna_subscriptions extends CDbMigration
{

    private $table = 'qna_subscriptions';
    private $userConstraint = 'fk_qna_sbscr_userid';
    private $qnaConstraint = 'fk_qna_sbscr_id';


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->createTable($this->table,[
            'userid' => 'bigint(20) unsigned NOT NULL',
            'qid' => 'bigint(20) unsigned NOT NULL',
            'PRIMARY KEY (qid,userid)'
        ]);

        $this->addForeignKey($this->userConstraint, $this->table, 'userid',
            'users', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey($this->qnaConstraint, $this->table, 'qid',
            'qna_questions', 'qid', 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
        $this->dropForeignKey($this->userConstraint, $this->table);
        $this->dropForeignKey($this->qnaConstraint, $this->table);
        $this->dropTable($this->table);
	}

}