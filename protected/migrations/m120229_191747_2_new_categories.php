<?php

class m120229_191747_2_new_categories extends CDbMigration
{
	public function up()
	{
		$this->insert('blog_categories', array( 'name' => 'מדריכי YII'));
		$this->insert('blog_categories', array( 'name' => 'כנסים והרצאות'));
	}

	public function down()
	{
		$this->delete('blog_categories', array('IN', 'name', array('מדריכי YII','כנסים והרצאות')));
	}

}