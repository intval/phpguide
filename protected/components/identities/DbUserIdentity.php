<?php

class DbUserIdentity extends CUserIdentity
{    
    
    
    /**
     * How many failed login attempts user can experience before his ip is locked 
     */
    const max_bruteforce_attempts = 5;
    
    /**
     * Instance of the User model
     * @var User
     */
    public $user;
    
    
    
    public function authenticate() 
    {

        if(static::is_ip_locked( Yii::app()->request->getUserHostAddress() ))
        {
            throw new BruteForceException();
        }
        
        $user = User::model()->find("login=:login", array('login' => $this->username ));
        
        if($user === null)
        {
            $this->errorCode = static::ERROR_USERNAME_INVALID;
            self::log_failed_attempt();
        }
        else if($user->password !== $this->get_expected_password($user))
        {
            $this->errorCode = static::ERROR_PASSWORD_INVALID;
            self::log_failed_attempt();
        }
        else
        {
            $this->user = $user;
            $this->errorCode = static::ERROR_NONE;
        }
        
        return !$this->errorCode;
        
    }
    
    
    private static function log_failed_attempt()
    {
        // add one to bruteforce counter
        Yii::app()->db
                ->createCommand("INSERT INTO `unauth` (`ip`, `time`) VALUES(:ip, NOW()) ")
                ->execute(array('ip' => Yii::app()->request->getUserHostAddress()))   ;
    }
    
     /**
     * Checks whether the ip is locked for bruteforcing
     * @param string $ip ipv4
     * @return bool true - if locked, false is not locked
     */
    private static function is_ip_locked($ip)
    {
        return Yii::app()
                -> db
                -> createCommand("SELECT COUNT(*) FROM `unauth` WHERE `ip`=:ip AND `time` > DATE_SUB(NOW(), INTERVAL 1 HOUR)")
                -> queryScalar(array('ip' => $ip)) 
                   >= static::max_bruteforce_attempts;

    }
    
    /**
     * Returns the password we expect to be in the DB for the corresponding user
     * Depends whether he is still using the old SHA1 algorithm, or whether his password has been already updated to blowfish
     * @param User $user instance of the User model
     * @return string password we expect to be in the db 
     */
    private function get_expected_password(User $user)
    {
        if(22 !== mb_strlen($user->salt))
        {
            $expected_db_password = sha1(mb_strtolower($this->username). $this->password);
        }
        else
        {
            $expected_db_password = WebUser::encrypt_password($this->password, $user->salt);
        }
        
        return $expected_db_password;
    }
    
    
   
    
    /**
    * Returns the unique identifier for the identity.
    * The default implementation simply returns {@link username}.
    * This method is required by {@link IUserIdentity}.
    * @return string the unique identifier for the identity.
    */
    public function getId()
    {
            return $this->user->id;
    }
        
}

/**
 * Indicates the authentication attempt has been blocked to avoid brute-force 
 */
class BruteForceException extends Exception{}
