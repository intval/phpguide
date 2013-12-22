<?php

class m131219_210207_qna_categories extends CDbMigration
{
	public function up()
	{
        $this->createTable('qna_categories', [
            'catid' => 'SERIAL',
            'cat_name' => 'string',
            'cat_description' => 'string'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

        $this->dbConnection->createCommand("
            INSERT INTO qna_categories (catid, cat_name, cat_description) VALUES
            (1, 'תכנות PHP', 'שאלות הקשורות לתכנות בשפת PHP'),
            (2, '.NET & C#', 'ושאר הטכנולוגיות (mvc, webapi, signalr)'),
            (3, 'JavaScript', 'nodejs, פריימוורקים, ספריות וצד לקוח'),
            (4, 'Android & IOS', 'פיתוח אפליקציות מובייל'),
            (5, 'Ruby & RoR', 'פורום נושאי רובי וריילס'),
            (6, 'Java', 'groovy, scala ומה שרץ על jvm'),
            (7, 'HTML, CSS, UI, UX', 'צד לקוח וממשק'),
            (8, 'אחר', 'כל השאר הנושאים, פרסומים והצעות');")->execute();

        $this->addColumn('qna_questions', 'categoryid', 'BIGINT(20) unsigned');
        $this->update('qna_questions', ['categoryid' => 1]);
        $this->createIndex('qna_question_category', 'qna_questions', 'categoryid');
        $this->addForeignKey('fk_qna_question_category', 'qna_questions', 'categoryid', 'qna_categories', 'catid', null, 'cascade');
	}

	public function down()
	{
		$this->dropForeignKey('fk_qna_question_category', 'qna_questions');
        $this->dropIndex('qna_question_category', 'qna_questions');
        $this->dropColumn('qna_questions', 'categoryid');
        $this->dropTable('qna_categories');
	}

}