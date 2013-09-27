<?php

/**
 * This is the model class for table "contest_submits".
 *
 * The followings are the available columns in table 'contest_submits':
 * @property string $id
 * @property string $problemid
 * @property string $userid
 * @property string $date
 * @property string $content
 * @property string $result
 *
 * The followings are the available model relations:
 * @property User $user
 * @property ContestProblem $problem
 */
class ContestSubmit extends DTActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contest_submits';
	}


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'userid'),
			'problem' => array(self::BELONGS_TO, 'ContestProblem', 'problemid'),
		);
	}

    protected function afterFind()
    {
        $this->result = json_decode($this->result);
        return parent::afterFind();
    }

    protected function beforeSave()
    {
        $this->result = json_encode($this->result);
        return parent::beforeSave();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContestSubmit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
