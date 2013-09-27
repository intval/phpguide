<?php

/**
 * This is the model class for table "contest_problems".
 *
 * The followings are the available columns in table 'contest_problems':
 * @property string $problemid
 * @property integer $contestid
 * @property string $title
 * @property string $text
 * @property string shortDesc
 *
 * The followings are the available model relations:
 * @property ContestSubmit[] $contestSubmits
 * @property integer userSubmits
 */
class ContestProblem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contest_problems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contestid, title, text', 'required'),
			array('contestid', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('problemid, contestid, title, text', 'safe', 'on'=>'search'),
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
			'contestSubmits' => array(self::HAS_MANY, 'ContestSubmit', 'problemid'),
            'userSubmitsCount'   => [self::STAT, 'ContestSubmit', 'problemid', 'condition' => 'userid = :uid', 'params' => ['uid' => Yii::app()->user->id]],
            'userSubmits'   => [self::HAS_MANY, 'ContestSubmit', 'problemid', 'condition' => 'userid = :uid', 'params' => ['uid' => Yii::app()->user->id]]
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'problemid' => 'Problemid',
			'contestid' => 'Contestid',
			'title' => 'Title',
			'text' => 'Text',
		);
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContestProblem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function defaultScope()
    {
        return [
            #'with' => 'userSubmits'
        ];
    }


}
