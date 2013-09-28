<?php

class DbUserIdentity extends CUserIdentity
{    
    
    
    /**How many failed login attempts user
     * can try to auth before his ip is locked */
    const max_bruteforce_attempts = 5;

    /** Indicates the ip is locked for bruteforcing */
    const ERROR_IP_LOCKED = 789;

    /**
     * Instance of the User model
     * @var User
     */
    public $user;


    /**
     * Constructor.
     * @param string $username username
     * @param string $password password
     */
    public function __construct($username,$password)
    {
        $this->username=$username;
        $this->password=$password;
    }
    
    
    public function authenticate()
    {
        $ip = Yii::app()->request->getUserHostAddress();

        if($this->isIpLocked($ip))
        {
            $this->errorCode = static::ERROR_IP_LOCKED;
            return $this->errorCode;
        }
        
        $this->user = User::model()->
            find("login=:login",['login' => $this->username]);

        
        if($this->user === null)
        {
            $this->errorCode = static::ERROR_USERNAME_INVALID;
            $this->logBruteforceAttempt($ip);
        }      
               //  db stored password !== expected_password(based on provided inputs)
        else if($this->user->password !== $this->get_expected_password())
        {
            $this->errorCode = static::ERROR_PASSWORD_INVALID;
            $this->user = null;
            $this->logBruteforceAttempt($ip);
        }
        else
        {
            $this->errorCode = static::ERROR_NONE;
        }
        
        return $this->errorCode;
        
    }
    
    
    private function logBruteforceAttempt($ip)
    {
        $query = 'INSERT INTO unauth (ip, time) VALUES(:ip, NOW()) ';
        Yii::app()->db->createCommand($query)->execute(['ip' => $ip])   ;
    }
    
     /**
     * Checks whether the ip is locked for bruteforcing
     * @param string $ip ipv4
     * @return bool true - if locked, false is not locked
     */
    private function isIpLocked($ip)
    {
        $query = 'SELECT COUNT(*) FROM unauth
                  WHERE ip=:ip AND time > DATE_SUB(NOW(), INTERVAL 1 HOUR)';

        return Yii::app()
            -> db
            -> createCommand($query)
            -> queryScalar(['ip' => $ip])
               >= static::max_bruteforce_attempts;

    }
    
    /**
     * Returns the password we expect to be in the DB for the corresponding user
     * Depends whether he is still using the old SHA1 algorithm, or whether his password has been already updated to blowfish
     * @return string password we expect to be in the db 
     */
    private function get_expected_password()
    {
        if(22 !== mb_strlen($this->user->salt))
        {
            $expected_db_password = sha1(
                mb_strtolower($this->username).$this->password
            );
        }
        else
        {
            $expected_db_password = WebUser::encrypt_password(
                $this->password, $this->user->salt
            );
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
