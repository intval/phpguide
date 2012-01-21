<?php

/**
 * This is the model class for table "qna_answers".
 *
 * The followings are the available columns in table 'qna_answers':
 * @property string $aid
 * @property integer $authorid
 * @property string $qid
 * @property string $bb_text
 * @property string $html_text
 * @property Datetime $time
 *
 * The followings are the available model relations:
 * @property User $author
 * @property QnaQuestions $question
 */
class QnaComment extends DTActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return QnaComments the static model class
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
		return 'qna_answers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bb_text', 'length', 'min'=>2),
			array('qid', 'numerical', 'integerOnly' => true, 'min' => 1)
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
			'question' => array(self::BELONGS_TO, 'QnaQuestions', 'qid'),
		);
	}

	public function defaultScope()
        {
            return array
            (
                'order'     =>  'time ASC',
                'with'      => array
                (
                    'author' => array
                    (
                        'select'   => array('real_name','login', 'id', 'email')
                    )
                )
            );
        }
    
}