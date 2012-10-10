<?php

/**
 * Used to log in user based on a User instance, without any validations or checks 
 */
class AuthorizedIdentity extends CUserIdentity
{
    /**
     * User model instance
     * @var User
     */
    public $user;
    
    /**
     * Instance of the User mode whom you'd like to log in
     * @param User $user 
     */
    public function __construct(User $user) 
    {
        $this->user  = $user;
    }
    
    /**
     * Always returns TRUE
     * @return boolean 
     */
    public function authenticate() 
    {
        $this->errorCode = static::ERROR_NONE;
        return true;
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