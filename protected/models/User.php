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
 * @property bool $is_registered
 *
 * The followings are the available model relations:
 * @property Blog[] $blogposts
 * @property QnaAnswers[] $qnaAnswers
 * @property QnaQuestions[] $qnaQuestions
 */
class User extends CActiveRecord
{
    
        /**
         * Indicates whether the current user is registered user, with email, chosen login and password
         * or not (one automatically created by the system for every logon)
         * @var bool
         */
        public $is_registered = false;
        
        /**
         * email used for automatically created (non registered) user accounts
         */
        const unregistered_guest_mail = 'anonymous@phpguide.co.il';
    
        
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
        
        
        
        protected function afterFind() 
        {
            $this->is_registered = $this->email !== $this->id . static::unregistered_guest_mail;
            return parent::afterFind();
        }
        
        /**
         * Creates new guest user account 
         */
        public static function createNewAnonymousUser()
        {
            $nextid = Yii::app()->db
                    ->createCommand( "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_schema = (SELECT DATABASE()) AND table_name = :tbl")
                    ->queryScalar(array('tbl' => static::model()->tableName()));
            
            $user = new User();
            
            $user->login = 'משתמש_' . $nextid;
            $user->email = $nextid . static::unregistered_guest_mail;
            $user->password = 'abc';
            $user->salt = 'abcabcabcabcabcabcabca';
            $user->ip = Yii::app()->request->getUserHostAddress();
            $user->is_registered = false;
            $user->real_name = '';
            
            $user->save();
            
            return $user;
        }

}