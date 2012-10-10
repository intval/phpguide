<?php

class SMFUserIdentity extends CUserIdentity
{
    /**
     * authenticated User instance
     * @var User
     */
    public $user;
    
    /**
     * Unserialized smf cookie
     * @var array
     */
    private $cookie;
    
    /**
     * smf cookie
     * @param CHttpCookie $smfcookie 
     */
    public function __construct($smfcookie)
    {
        $this->cookie = unserialize($smfcookie->value);
    }
    
    public function authenticate() 
    {

        // Create the selection condition
        $criteria = new CDbCriteria(array
        (      
            'condition' => "id = :id AND SHA1(CONCAT(`password`, `salt`)) = :cookiepass",
            'params'    => array(':id' => intval($this->cookie[0]), ':cookiepass' => $this->cookie[1])
        ));
        
        // fetch the user. if fails -> returs null
        $user = User::model()->find($criteria); 
        
        if(null === $user )
        {
            $this->errorCode = static::ERROR_UNKNOWN_IDENTITY;
        }
        else
        {
            $this->username = $user->login;
            $this->user = $user;
            $this->errorCode = static::ERROR_NONE;
        }
        
        return !$this->errorCode;
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
