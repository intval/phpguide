<?php

/**
 * This is the model class for table "zzsmf_themes".
 *
 * The followings are the available columns in table 'zzsmf_themes':
 * @property integer $id_member
 * @property integer $id_theme
 * @property string $variable
 * @property string $value
 */
class UserInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserInfo the static model class
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
		return 'zzsmf_themes';
	}


}