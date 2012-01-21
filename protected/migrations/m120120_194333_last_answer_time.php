<?php

class m120120_194333_last_answer_time extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn('qna_questions', 'last_answer_time', 'TIMESTAMP NULL DEFAULT NULL');
		$this->createIndex('iLast_answer_time', 'qna_questions', 'last_answer_time');
		
		// new triggers for safeUp
		$insert_trigger =
		"
		CREATE TRIGGER qna_answers_ondelete
		after DELETE ON qna_answers FOR EACH ROW
		BEGIN
			UPDATE qna_questions SET answers = answers -1, last_answer_time = (SELECT MAX (time) FROM qna_answers WHERE qna_answers.qid = OLD.qid)
			WHERE qna_questions.qid = OLD.qid;
		END
		";
		
		$delete_trigger =
		"
		CREATE TRIGGER qna_answers_oninsert AFTER INSERT ON qna_answers
		FOR EACH
		ROW
		BEGIN
			UPDATE qna_questions SET answers = answers +1, last_answer_time = NOW() WHERE qna_questions.qid = NEW.qid;
		END
		";
		
		Yii::app()->db->createCommand('DROP TRIGGER IF EXISTS qna_answers_ondelete')->execute();
		Yii::app()->db->createCommand('DROP TRIGGER IF EXISTS qna_answers_oninsert')->execute();
		
		Yii::app()->db->createCommand($insert_trigger)->execute();
		Yii::app()->db->createCommand($delete_trigger)->execute();
		
		$this->execute('UPDATE qna_questions SET last_answer_time = (SELECT MAX(time) FROM qna_answers WHERE qna_answers.qid = qna_questions.qid)');
	}

	public function safeDown()
	{
		$this->dropIndex('iLast_answer_time', 'qna_questions');
		$this->dropColumn('qna_questions', 'last_answer_time');
		
		
		// Previous triggers for safeDown
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
		
		Yii::app()->db->createCommand('DROP TRIGGER IF EXISTS qna_answers_ondelete')->execute();
		Yii::app()->db->createCommand('DROP TRIGGER IF EXISTS qna_answers_oninsert')->execute();
		
		Yii::app()->db->createCommand($insert_trigger)->execute();
		Yii::app()->db->createCommand($delete_trigger)->execute();
	}
	
}