<?php

class m120107_230853_likes_table extends CDbMigration
{
	public function safeUp()
	{
            $this->createTable('blog_likes', array(
            	'userid' => 'bigint(8) unsigned',
            	'postid' => 'smallint(5) unsigned',
            	'time'	 => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            	'like'	 => 'tinyint(1) COMMENT \'Either 1 or -1\'',
            	'PRIMARY KEY(userid, postid)'
            ), 'ENGINE=InnoDB');
            
            $this->addForeignKey('userid2users', 'blog_likes', 'userid', 'users', 'id', 'cascade', 'cascade');
            $this->addForeignKey('blogid2blogs', 'blog_likes', 'postid', 'blog',  'id', 'cascade', 'cascade');
	}

	public function down()
	{
		$this->dropTable('blog_likes');
	}
}