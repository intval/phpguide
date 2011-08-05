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
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('postid, catid', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'postid' => 'Postid',
			'catid' => 'Catid',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('postid',$this->postid);
		$criteria->compare('catid',$this->catid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}