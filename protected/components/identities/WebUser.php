<?php

class WebUser extends CWebUser
{
     /**
     * Pattern of the blowfish salt. 
     * 2a indicates blowfish as crypt's algorithm
     * 06 - complexity cost
     * 22 characters of salt
     * Consider php.net/crypt for further assistance 
     */
    const blowfish_hash = '$2a$06$%\'_22.22s$';
    
    
    /** Cookie name to store user's info */
    const OLD_SMF_COOKIE_NAME = 'SMFCookie63';
    
    public $guestName='מישהו לא מוכר';
    public $allowAutoLogin = true;
    
    
    /**
     * Every request(f5 press) the user makes we update last_visit time in the db for him
     * since we want to do it once per request, this indicates whether we had done it already this request or not
     * @var bool
     */
    private $was_last_visit_time_updated = false;

    /**
     * Holds instance of the currently authorized user
     * @var User
     */
    private $user = null;
    
    /**
     * Stores user's plain text password for later hashing algorithm upgrade
     * @var string
     */
    private $plain_password;
    
    public function login( $identity, $duration = 0)
    {
    	$this->user = $identity->user;
        $this->setState('user', $identity->user);
        $this->plain_password = $identity->password;

        return parent::login($identity, $duration);
    }
    
    
    public function __get($key) 
    {
        $user = $this->getUser(); 
        return isset($user->{$key}) ? $user->{$key} : parent::__get($key);
    }

    /**
     * Returns instance of the user mode from session
     * @return User
     */
    protected function getUser()
    { 
    	if( null !== $this->user )
    	{
    		return $this->user;
    	}
        else if(!$this->hasState('user') )
        {
            $userid = $this->getId();
            $user = null;
            
            if( null !== $userid )
            {
            	$user = User::model()->findByPk($userid);
            }
            
            if( null === $user )
            {
            	$user = User::createNewAnonymousUser();
            }        
            
            $identity = new AuthorizedIdentity($user);
            $this->login($identity, Yii::app()->params['login_remember_me_duration']);    
        }
        // User instance comes from session.
        else if(!$this->was_last_visit_time_updated)
        {
        	
        	$user = $this->getState('user');
        	

        	$this->setState('prev_visit', $user->last_visit);
        	$this->was_last_visit_time_updated = true;
        	
        	$user->last_visit = new SDateTime;
        	$this->setState('user', $user);
        	
        	User::model()->updateByPk($user->id, array('last_visit' => $user->last_visit ));
        }
        
        return $this->getState('user');
    }

    
    protected function afterLogin($fromCookie)
    {
    	$this->setState('prev_visit', $this->getUser()->last_visit);
        $this->updateUserDataOnLoginSuccess($fromCookie);
        $this->was_last_visit_time_updated = true;
        return parent::afterLogin($fromCookie);
    }
    

    
    
    /**
     * If the user logged in successfuly, we should update some data about him, like the last login time
     * @param bool $fromCookie indicates whether the login takes place using cookie or login form
     */
    private function updateUserDataOnLoginSuccess($fromCookie)
    {
        $newlogin_attributes = $this->last_login_update_params();
        $provider_attributes = $new_pass_attributes = array();
        
        if(!$fromCookie)
        {
            $provider_attributes = $this->external_auth_provider_storing_params();
            $new_pass_attributes = $this->password_algorithm_upgrade($this->plain_password);
        }
        
        $attributes = array_merge($newlogin_attributes, $provider_attributes, $new_pass_attributes);
        User::model()->updateByPk($this->user->id, $attributes);
    }
        
    
    /**
     * Returns array with model attributes to update on successfull login
     * @return array 
     */
    private function last_login_update_params()
    {
        return array
        (
            'ip' => Yii::app()->request->getUserHostAddress(),
            'last_visit' => new SDateTime()
        );
    }
    
    /**
     * Returns array of attributes to save for the user, if he logged in after authenticating with 
     * an external oauth provider 
     * @param User $user the authenticated user
     * @return array
     */
    private function external_auth_provider_storing_params()
    {
        $attributes = array();
        if(isset(Yii::app()->session['provider'])) 
        {
            $provider = Yii::app()->session['provider'];
            $provider_dbcolumn_name = ServiceUserIdentity::$service2fieldMap[$provider->serviceName];

            if(empty($this->{$provider_dbcolumn_name}))
            {
                $userInfo = $provider->getAttributes();
                $attributes[ $provider_dbcolumn_name ] = $userInfo['id'];
                
                if(empty($this->real_name))
                {
                    $attributes['real_name'] = $userInfo['name'];
                }
            }
            Yii::app()->session['provider'] = null;
        }
        return $attributes;
    }
    
    
    /**
     * Sets new attribute values and rehashes password for user in case he is still using the sha1 based pw encryption
     * @param User $user
     * @param type $password plain password user used to input for authentication
     * @return array
     */
    private function password_algorithm_upgrade( &$password)
    {
        $attributes = array();
        if(null !== $this->plain_password && 22 !== mb_strlen($this->salt))
        {
            $salt = Helpers::randString(22);
            $attributes['salt'] = $salt;
            $attributes['password'] = static::encrypt_password($password, $salt);
        }
        return $attributes;
    }

    
    
    
    
    
    
    
    
    
    
    
    /**
     * Overides the method used by YII to recover authorized user's info from cookie 
     * for long term authentication with (remember me). This particular implementation
     * allows to recover not only from Yii cookie, but also from SMF cookie, used for integrated authentication.
     * In some point in the future this should be reverted to the original Yii's method.
     */    
    protected function restoreFromCookie() 
    {
        $restored = false;
        
        $smfcookie = Yii::app()->request->getCookies()->itemAt(static::OLD_SMF_COOKIE_NAME);
        if($smfcookie !== null)
        {
            $identity = new SMFUserIdentity($smfcookie);
            
            if($identity->authenticate())
            {
                $this->login($identity, Yii::app()->params['login_remember_me_duration']);
                $restored = true;
            }
            
            Yii::app()->request->getCookies()->remove($smfcookie->name);    
        }
        
        if(!$restored)
        {
            parent::restoreFromCookie();
        }
        else
        {
        	$this->afterLogin(true);
        }
        
    }

    
    
     /**
     * Encrypts plain text password in blowfish using provided salt
     * @param string $password plain text password
     * @param string $salt 22 chars long salt
     * @return string encrypted pass 
     */
    public static function encrypt_password($password, $salt)
    {
        return '' === $password ? '' : crypt($password, sprintf(static::blowfish_hash, $salt) );
    }
    
}




