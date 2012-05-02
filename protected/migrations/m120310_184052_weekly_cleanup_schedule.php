<?php

class m120310_184052_users_table_clean_schedule extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute
		("
				
			CREATE EVENT `clear_users_table` 
			ON SCHEDULE EVERY 1 WEEK ON COMPLETION PRESERVE ENABLE 
			DO 
				begin
					delete u
					FROM `users` u
					join 
					(
						select users.id from users
						
						LEFT JOIN blog ON blog.author_id = users.id
						LEFT JOIN qna_answers on users.id = qna_answers.authorid
						LEFT JOIN qna_questions on  qna_questions.authorid = users.id
						
						WHERE `last_visit` > DATE_SUB(NOW(), INTERVAL 14 DAY) and reg_date is null and fbid is null and googleid is null and twitterid is null and  password = 'abc'
						
						group by users.id
						having COUNT( blog.id) = 0 AND COUNT(qna_questions.qid) = 0 AND COUNT(qna_answers.aid) = 0
					) j
					on u.id = j.id;
				
				
					optimize table users;
				end;
				
		");
		
		
		$this->execute
		("

			CREATE EVENT `truncate_unauth`
			ON SCHEDULE EVERY 1 WEEK ON COMPLETION PRESERVE ENABLE
			DO TRUNCATE TABLE `unauth` 
				
		");
		
		
		$this->execute
		("
		
				CREATE EVENT `clear_password_recovery`
				ON SCHEDULE EVERY 1 WEEK ON COMPLETION PRESERVE ENABLE
				DO DELETE FROM `password_recovery` WHERE validity < NOW()
		
		");
		
	}

	public function safeDown()
	{
		$this->execute("DROP EVENT `clear_users_table`");
		$this->execute("DROP EVENT `truncate_unauth`");
		$this->execute("DROP EVENT `clear_password_recovery`");
	}
	
}