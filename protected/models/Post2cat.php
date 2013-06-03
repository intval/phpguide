<?php

/**
 * This is the model class for table "blog_post2cat".
 *
 * The followings are the available columns in table 'blog_post2cat':
 * @property integer $postid
 * @property integer $catid
 */
class Post2cat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Post2cat the static model class
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
		return 'blog_post2cat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('postid, catid', 'required'),
			array('postid, catid', 'numerical', 'integerOnly'=>true),
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