<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $login
 * @property string $real_name
 * @property string $last_login
 * @property string $reg_date
 * @property string $ip
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $fbid
 * @property string $googleid
 * @property string $twitterid
 * @property integer $points
 * @property bool $is_admin
 *
 * The followings are the available model relations:
 * @property Blog[] $blogposts
 * @property QnaAnswers[] $qnaAnswers
 * @property QnaQuestions[] $qnaQuestions
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('email', 'email', 'checkMX' => true, 'allowEmpty' => false, 'message' => 'אתה בטוח שהאימייל כתוב נכון? אולי תנסה אימייל אחר?'),
                        array('login', 'length', 'min' => 3, 'max'=>20, 'allowEmpty' => false, 'tooLong' => 'בחר שם משתמש קצר יותר, 20 תווים לכל היותר', 'tooShort' => 'בחר שם משתמש ארוך יותר, 3 תווים לפחות'),
                        array('password', 'required', 'message' => 'ומה עם הסיסמה?')
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
			'blogposts' => array(self::HAS_MANY, 'Blog', 'author_id'),
			'qnaAnswers' => array(self::HAS_MANY, 'QnaAnswers', 'authorid'),
			'qnaQuestions' => array(self::HAS_MANY, 'QnaQuestions', 'authorid'),
		);
	}
        
        
        public function beforeSave() 
        {
            if($this->isNewRecord)
            {
                if(null === $this->ip)
                {
                    $this->ip = Yii::app()->request->getUserHostAddress();
                }

                if(null === $this->reg_date)
                {
                    $this->reg_date = new CDbExpression('NOW()');
                }
            }
            
            return parent::beforeSave();
        }

}