<?php

class m120108_174935_likes_ip_as_pk extends CDbMigration
{
	public function safeUp()
	{
		$this->dropForeignKey('userid2users', 'blog_likes');
		$this->alterColumn('blog_likes', 'userid', 'VARCHAR( 32 ) NOT NULL');
		$this->renameColumn('blog_likes', 'userid', 'ip');
	}

	public function safeDown()
	{
		$this->alterColumn('blog_likes', 'ip', 'bigint(8) unsigned NOT NULL');
		$this->renameColumn('blog_likes', 'ip', 'userid');
		$this->addForeignKey('userid2users', 'blog_likes', 'userid', 'users', 'id', 'cascade', 'cascade');
	}
}