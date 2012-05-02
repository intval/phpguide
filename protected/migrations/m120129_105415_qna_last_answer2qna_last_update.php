<?php

class m120129_105415_qna_last_answer2qna_last_update extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute('UPDATE qna_questions SET last_answer_time = time WHERE last_answer_time is NULL');
		$this->renameColumn('qna_questions', 'last_answer_time', 'last_activity');
		$this->alterColumn('qna_questions', 'last_activity', 'TIMESTAMP NOT NULL');
		
		// new triggers for safeUp
		$insert_trigger =
		"
		CREATE TRIGGER qna_answers_ondelete
		after DELETE ON qna_answers FOR EACH ROW
		BEGIN
			UPDATE qna_questions SET answers = answers -1, last_activity = 
		 	COALESCE((SELECT MAX(time) FROM qna_answers WHERE qna_answers.qid = OLD.qid), qna_questions.time)
			WHERE qna_questions.qid = OLD.qid;
		END
		";
		
		$delete_trigger =
		"
		CREATE TRIGGER qna_answers_oninsert AFTER INSERT ON qna_answers
		FOR EACH
		ROW
		BEGIN
		UPDATE qna_questions SET answers = answers +1, last_activity = NOW() WHERE qna_questions.qid = NEW.qid;
		END
		";
		
		Yii::app()->db->createCommand('DROP TRIGGER IF EXISTS qna_answers_ondelete')->execute();
		Yii::app()->db->createCommand('DROP TRIGGER IF EXISTS qna_answers_oninsert')->execute();
		
		Yii::app()->db->createCommand($insert_trigger)->execute();
		Yii::app()->db->createCommand($delete_trigger)->execute();
	}

	public function safeDown()
	{
		$this->renameColumn('qna_questions', 'last_activity', 'last_answer_time');
		$this->alterColumn('qna_questions', 'last_answer_time', 'TIMESTAMP NULL DEFAULT NULL');
		
		$this->execute
		('
			UPDATE qna_questions SET last_answer_time = 
			(
				SELECT MAX( time )
				FROM qna_answers
				WHERE qna_answers.qid = qna_questions.qid
			) '
		);	
		
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
	}
	
}