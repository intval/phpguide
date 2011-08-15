<?php

/**
 * This is the model class for table "blog_plain".
 *
 * The followings are the available columns in table 'blog_plain':
 * @property integer $id
 * @property string $plain_description
 * @property string $plain_content
 */
class ArticlePlainText extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ArticlePlainText the static model class
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
		return 'blog_plain';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('plain_description, plain_content', 'required')
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
                    'Article' => array(self::BELONGS_TO, 'Article', 'id')
		);
	}

}