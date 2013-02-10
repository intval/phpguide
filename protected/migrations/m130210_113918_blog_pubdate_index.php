<?php

class m130210_113918_blog_pubdate_index extends CDbMigration
{
	public function up()
	{
        $this->createIndex('blog_pubdate_index', Article::model()->tableName(), 'pub_date');
	}

	public function down()
	{
		$this->dropIndex('blog_pubdate_index', Article::model()->tableName());
	}
}