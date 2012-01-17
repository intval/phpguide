<?php

class m120113_184432_qnaanswer_trigers extends CDbMigration
{
	public function safeUp()
	{	
		$insert_trigger = 
		"
			CREATE TRIGGER qna_answers_ondelete
			before DELETE ON qna_answers FOR EACH ROW 
			BEGIN 
				UPDATE qna_questions SET answers = answers -1 WHERE qna_questions.qid = OLD.qid;
			END
		";
		
		$delete_trigger = 
		"
			CREATE TRIGGER qna_answers_oninsert AFTER INSERT ON qna_answers
			FOR EACH
			ROW
			BEGIN
				UPDATE qna_questions SET answers = answers +1 WHERE qna_questions.qid = NEW.qid;
			END
		";
		
		
		Yii::app()->db->createCommand($insert_trigger)->execute();
		Yii::app()->db->createCommand($delete_trigger)->execute();
	}

	public function safeDown()
	{
		Yii::app()->db->createCommand('DROP TRIGGER qna_answers_ondelete')->execute();
		Yii::app()->db->createCommand('DROP TRIGGER qna_answers_oninsert')->execute();
	}

}