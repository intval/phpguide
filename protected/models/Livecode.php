<?php

/**
 * This is the model class for table "code_tinyurl".
 *
 * The followings are the available columns in table 'code_tinyurl':
 * @property integer $id
 * @property string $code
 * @property string $checksum
 */
class Livecode extends DTActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Livecode the static model class
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
		return 'code_tinyurl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code', 'required'),
			array('code', 'length', 'min' => 1, 'allowEmpty' => false),
			array('checksum', 'length', 'max'=>32),

		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

}