<?php

class ServiceUserIdentity extends CUserIdentity
{
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
        $dbfield = static::$service2fieldMap[$this->provider->getServiceName()];
        $user = User::model()->findByAttributes(array($dbfield => $userInfo['id']));

        if(null === $user)
            return false;

        $this->user = $user;
        return true;
    }
    
    public function getId()
    {
        return $this->user->id;
    }
    
    
}