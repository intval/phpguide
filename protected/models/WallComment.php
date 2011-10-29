<?php

/**
 * This is the model class for table "wall_comments".
 *
 * The followings are the available columns in table 'wall_comments':
 * @property integer $cid
 * @property string $parentid
 * @property string $content
 * @property integer $author
 *
 * The followings are the available model relations:
 * @property User $author0
 * @property WallPost $parent
 */
class WallComment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return WallComment the static model class
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
		return 'wall_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parentid, content, author', 'required'),
			array('author', 'numerical', 'integerOnly'=>true),
			array('parentid', 'length', 'max'=>10)
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
			'author' => array(self::BELONGS_TO, 'User', 'author'),
			'parent' => array(self::BELONGS_TO, 'WallPost', 'parentid'),
		);
	}

}