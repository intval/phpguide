<?php

/**
 * This is the model class for table "wall".
 *
 * The followings are the available columns in table 'wall':
 * @property string $id
 * @property integer $authorid
 * @property string $htmltext
 *
 * The followings are the available model relations:
 * @property User $author
 * @property WallComment[] $wallComments
 */
class WallPost extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return WallPost the static model class
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
		return 'wall';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('authorid, htmltext', 'required'),
			array('authorid', 'numerical', 'integerOnly'=>true)
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
			'author' => array(self::BELONGS_TO, 'User', 'authorid'),
			'comments' => array(self::HAS_MANY, 'WallComment', 'parentid'),
		);
	}

}