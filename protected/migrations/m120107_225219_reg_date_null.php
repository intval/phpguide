<?php

class m120107_225219_reg_date_null extends CDbMigration
{
	public function up()
	{
            $this->alterColumn( 'users', 'reg_date', 'TIMESTAMP NULL DEFAULT NULL');
            $this->update( 'users' , array('reg_date' => null), 'reg_date = 0000-00-00');
	}

	public function down()
	{
            $this->update( 'users' , array('reg_date' => '0000-00-00'), 'reg_date IS NULL');
            $this->alterColumn( 'users', 'reg_date', 'TIMESTAMP NOT NULL');
	}
}