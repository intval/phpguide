<?php

class ServiceUserIdentity extends CUserIdentity
{
    const ERROR_NOT_AUTHENTICATED = 3;
    
    public static $service2fieldMap = array
        (
            'facebook' => 'fbid',
            'google' => 'googleid',
            'twitter' => 'twitterid'
        );
    
    /**
     * Instance of the external authentication provider
     * @var IAuthService
     */
    private $provider;
    
    /**
     * Authenticated user's model
     * @var User
     */
    public $user;
    
    public function __construct(IAuthService $provider)
    {
        $this->provider = $provider;
    }
    
    public function isKnownUser() 
    {
        
        $userInfo  = $this->provider->getAttributes();
        $dbfield = static::$service2fieldMap[$this->provider->serviceName];
        
        $user = User::model()->findByAttributes(array($dbfield => $userInfo['id']));
        if($user === null)
        {
            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
        }
        else 
        {
            $this->user = $user;
            $this->username = $user->login;
            $this->errorCode = self::ERROR_NONE;
        }
        
        return !$this->errorCode;
    }
    
    public function getId()
    {
        return $this->user->id;
    }
    
    
}