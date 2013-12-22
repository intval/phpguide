<?php

/**
 * This is the model class for table "qna_categories".
 *
 * The followings are the available columns in table 'qna_categories':
 * @property string $catid
 * @property string $cat_name
 * @property string $cat_description
 *
 * The followings are the available model relations:
 * @property QnaQuestions[] $qnaQuestions
 */
class QnaCategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qna_categories';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'qnaQuestions' => array(self::HAS_MANY, 'QnaQuestion', 'category'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'catid' => 'Catid',
			'cat_name' => 'Cat Name',
			'cat_description' => 'Cat Description',
		);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QnaCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
