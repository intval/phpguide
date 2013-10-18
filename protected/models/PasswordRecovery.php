<?php

/**
 * This is the model class for table "password_recovery".
 *
 * The followings are the available columns in table 'password_recovery':
 * @property integer $id
 * @property string $userid
 * @property string $key
 * @property string $validity
 * @property string $ip
 *
 * The followings are the available model relations:
 * @property User $user
 */
class PasswordRecovery extends DTActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasswordRecovery the static model class
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
		return 'password_recovery';
	}



	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userid'),
		);
	}




    const ERROR_USER_NOT_FOUND = 543;
    const ERROR_INVALID_EMAIL = 743;
    const ERROR_NONE = 843;
    const ERROR_INVALID_KEY = - 943;
    const ERROR_RECOVER_TIMEOUT = - 94234;


    private $recoveryUrl = 'PwRecovery/resetUrl?id=%s&key=%s';


    public function requestRecovery($login, $email, $ip, $sendEmail = true)
    {
        sleep(1); // prevent bruteforce

        /** @var User $user */
        $user = User::model()->getUserByLogin($login);

        if(null === $user)
            return self::ERROR_USER_NOT_FOUND;

        if($email !== $user->email)
            return self::ERROR_INVALID_EMAIL;

        $this->createRecoveryRecord($user, $ip);

        if($sendEmail)
            $this->sendRecoveryLetter($user);

        return self::ERROR_NONE;
    }

    private function createRecoveryRecord(User $user, $ip)
    {
        $this->userid = $user->id;
        $this->ip = $ip;
        $this->key = Helpers::randString(20);
        $this->validity = new SDateTime('+7 day');

        if($this->save())
            return $this->id;
        else
            throw new \CException("Couldnt save recovery record.
                Validation errors: ".print_r($this->getErrors(),true));
    }

    private function sendRecoveryLetter(User $user)
    {
        $url = bu(sprintf($this->recoveryUrl, $this->id, $this->key));
        $data = ['username' => $user->login, 'recovery_url' => $url];

        $mailContent = Yii::app()->controller->
            renderPartial('//emails/passwordRecovery', $data, true, false);

        $user->sendEmail( "שחזור סיסמה באתר phpguide", $mailContent);
    }


    /**
     * @param int $id recoveryModel id (pk in the table)
     * @param string $key uniq identifier to make sure this wasn't guessed
     * @return int error state
     */
    public function recover($id, $key)
    {
        /** @var PasswordRecovery $pwr  */
        $pwr = $this->findByPk($id, '`key`=:k',[':k' => $key]);


        if($pwr === null || $pwr->key !== $key)
            return self::ERROR_INVALID_KEY;

        if($pwr->validity < new DateTime())
            return self::ERROR_RECOVER_TIMEOUT;

        $pwr->user->authorize();
        $pwr->delete();
        return self::ERROR_NONE;
    }


}