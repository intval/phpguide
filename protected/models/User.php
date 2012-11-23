<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $login
 * @property string $real_name
 * @property SDateTime $last_visit
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
 * @property string $gender
 * @property SDateTime $birthdate
 * @property string $city
 * @property string $site
 * @property string $about
 *
 * The followings are the available model relations:
 * @property Article[] $blogposts
 * @property Comment[] $blogComments
 * @property QnaComment[] $qnaAnswers
 * @property QnaQuestion[] $qnaQuestions
 */
class User extends DTActiveRecord
{


    const ERROR_USERNAME_TAKEN = 323;
    const ERROR_NONE = 454;


	/**
     * @param string $className
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
		$checkmx = !defined('YII_DEBUG');
		
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array
		(
            array('email', 'email', 'checkMX' => $checkmx, 'allowEmpty' => false, 'message' => 'אתה בטוח שהאימייל כתוב נכון? אולי תנסה אימייל אחר?'),
            array('login', 'length', 'min' => 3, 'max'=>20, 'allowEmpty' => false, 'on' => 'registration', 'tooLong' => 'בחר שם משתמש קצר יותר, 20 תווים לכל היותר', 'tooShort' => 'בחר שם משתמש ארוך יותר, 3 תווים לפחות'),
            array('password', 'required', 'message' => 'ומה עם הסיסמה?'),
			array('city', 'length', 'min'=>2, 'max'=>30),
			array('site', 'url', 'allowEmpty' => true),
			array('about', 'length'),
			array('birthdate', 'match', 'pattern' => '#\d{1,2}/\d{1,2}/(19|20)\d{2}#'),
			array('gender', 'in', 'range' => array('male', 'female'), 'allowEmpty' => false)
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
			'blogposts' => array(self::HAS_MANY, 'Article', 'author_id'),
			'blogComments' => array(self::HAS_MANY, 'BlogComments', 'authorid'),
			'qnaAnswers' => array(self::HAS_MANY, 'QnaAnswers', 'authorid'),
			'qnaQuestions' => array(self::HAS_MANY, 'QnaQuestion', 'authorid')
		);
	}
        
	
	
	
	
	
	
	/**
	 * Updates user's points by specified diff amount
	 * ie update points for user 1 by +5
	 *
	 * @param int $pointsDiff by how many should increase or decrease points
	 * @example $User->updatePointsBy( $id = 1, $diff = +20 );
	 */
	public function updatePointsBy($pointsDiff)
	{
		$this->updateCounters
		(
			['points' => $pointsDiff],
			"id = :id",
			[':id' => $this->id]
		);

        if(null !== $this->points)
            $this->points += $pointsDiff;

	}


    public function sendEmail($subject, $text)
    {
        helpers::sendMail($this->email, $subject, $text);
    }




    public function getUserByLogin($login)
    {
        return static::model()->findByAttributes(['login' => $login]);
    }



    public function authorize()
    {
        $identity = new AuthorizedIdentity($this);
        $loginDuration = Yii::app()->params['login_remember_me_duration'];
        Yii::app()->user->login($identity, $loginDuration);
    }


    public function register($login, $email, $password = null, array $externalAuthData = null)
    {
        if($this->countByAttributes(['login' => $login]) > 0)
            return self::ERROR_USERNAME_TAKEN;

        $this->setRegistrationAttributes($login, $email, $password, $externalAuthData);

        if(!$this->validate())
            return $this->getErrors();

        var_dump($this->save());
        $this->authorize();
        return self::ERROR_NONE;

    }

    private function setRegistrationAttributes($login, $email, $password, array $externalAuthData)
    {
        $this->setScenario('registration');
        $this->attributes = array('login' => $login, 'email' => $email);
        $this->reg_date = new SDateTime();
        $this->last_visit = new SDateTime();
        $this->salt = Helpers::randString(22);
        $this->ip = Yii::app()->request->getUserHostAddress();
        $this->gender = 'male';

        if(null !== $externalAuthData)
        {
            $this->setRegExternalAuthData($externalAuthData);

            if (empty($password))
                $this->password = WebUser::encrypt_password(Helpers::randString(22), $this->salt);
        }
    }

    private function setRegExternalAuthData(array $externalAuthData)
    {
        if(sizeof($externalAuthData) < 1)
            return false;

        $realName = '';

        foreach($externalAuthData as $serviceName => $userinfo)
        {
            $serviceFieldName = ServiceUserIdentity::$service2fieldMap[$serviceName];
            $this->{$serviceFieldName} = $userinfo['id'];
            $realName = !empty($realName) ?: $userinfo['name'];
        }

        $this->real_name = $realName;
        return true;
    }

}