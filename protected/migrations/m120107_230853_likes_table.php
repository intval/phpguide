<?php

class m120107_230853_likes_table extends CDbMigration
{
	public function up()
	{
            $this->createTable('blog_likes', array(
            	'userid' => 'mediumint(8) unsigned',
            	'postid' => 'smallint(5) unsigned',
            	'time'	 => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            	'like'	 => 'tinyint(1) COMMENT \'Either 1 or -1\'',
            	'PRIMARY KEY(userid, postid)'
            ), 'ENGINE=InnoDB');
	}

	public function down()
	{
		$this->dropTable('blog_likes');
	}
}