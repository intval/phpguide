<?php

/**
 * This is the model class for table "password_recovery".
 *
 * The followings are the available columns in table 'password_recovery':
 * @property integer $id
 * @property string $userid
 * @property string $key
 * @property string $validity
 * @property string $ip
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class PasswordRecovery extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasswordRecovery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'password_recovery';
	}



	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

}