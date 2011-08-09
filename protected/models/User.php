<?php

/**
 * This is the model class for table "zzsmf_members".
 *
 * The followings are the available columns in table 'zzsmf_members':
 * @property integer $id_member
 * @property string $member_name
 * @property string $date_registered
 * @property integer $posts
 * @property integer $id_group
 * @property string $lngfile
 * @property string $last_login
 * @property string $real_name
 * @property integer $instant_messages
 * @property integer $unread_messages
 * @property integer $new_pm
 * @property string $buddy_list
 * @property string $pm_ignore_list
 * @property integer $pm_prefs
 * @property string $mod_prefs
 * @property string $message_labels
 * @property string $passwd
 * @property string $openid_uri
 * @property string $email_address
 * @property string $personal_text
 * @property integer $gender
 * @property string $birthdate
 * @property string $website_title
 * @property string $website_url
 * @property string $location
 * @property string $icq
 * @property string $aim
 * @property string $yim
 * @property string $msn
 * @property integer $hide_email
 * @property integer $show_online
 * @property string $time_format
 * @property string $signature
 * @property double $time_offset
 * @property string $avatar
 * @property integer $pm_email_notify
 * @property integer $karma_bad
 * @property integer $karma_good
 * @property string $usertitle
 * @property integer $notify_announcements
 * @property integer $notify_regularity
 * @property integer $notify_send_body
 * @property integer $notify_types
 * @property string $member_ip
 * @property string $member_ip2
 * @property string $secret_question
 * @property string $secret_answer
 * @property integer $id_theme
 * @property integer $is_activated
 * @property string $validation_code
 * @property string $id_msg_last_visit
 * @property string $additional_groups
 * @property string $smiley_set
 * @property integer $id_post_group
 * @property string $total_time_logged_in
 * @property string $password_salt
 * @property string $ignore_boards
 * @property integer $warning
 * @property string $passwd_flood
 * @property integer $pm_receive_from
 * @property integer $is_registered
 * @property string $full_name
 * @property integer $is_blog_admin
 * @property string $last_site_visit
 */
class User extends CActiveRecord
{
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
		return 'zzsmf_members';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
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
                    'articles' => array(self::HAS_MANY, 'Article',  'id_member' ),
                    'about'    => array(self::HAS_ONE,  'UserInfo', 'id_member', 'on' => 'about.id_theme = 1 AND variable="cust_37"' )
		);
	}

        
        
        
        
        
        
        
        
        /** @var User refers to the current user model */
        private static $current_user; 
        
        
        /**
     * Returns User instance of the current user
     * @return User
     */
    public static function get_current_user()
    {
        if( !self::$current_user) 
        {
            
            // Attemp to find user from session data
            $user = self::getUserBySession();
            
            // Maybe he has a forum's remember me cookie
            if($user === null) $user = self::getUserByCookie ();
            
            // create new, non existing yet, user
            if($user === null) $user = self::createNewUser();
                
            $user->make_user_current();
        }
        
        return self::$current_user;
    }
        
        
    
     /** Sets the session/cookie data the way a user will become current_user    */
     private function make_user_current()
     {
         Yii::app()->session['user'] =  $this;
         self::$current_user = & $this;
         setcookie('SMFCookie63', serialize(array($this->id_member, sha1($this->passwd. $this->password_salt), time()+315360000, 0)), time()+315360000, '/');
     }
     
	 /** Destory the session, and clean up cookie data */
	 public function logout()
	 {
		Yii::app()->session->clear();
		Yii::app()->session->destroy();
		unset(Yii::app()->request->cookies['SMFCookie63']);
	 }
        
    /**
     * Checks whether current users info is stored in session
     * @return User
     */
    private static function getUserBySession()
    {
        if( isset(Yii::app()->session['user']) ) 
        {
           return Yii::app()->session['user'];
        }
        else
        {
            return null;
        }
    }
    
    private static function getUserByCookie()
    {
        // default return value
        $user = null;
        
        if ( isset($_COOKIE['SMFCookie63']) && mb_strlen($_COOKIE['SMFCookie63']) > 15)
        {
            // unserialize cookies data
            $cookie = unserialize($_COOKIE['SMFCookie63']);

            // Create the selection condition
            $criteria = new CDbCriteria(array
            (      
                'condition' => "`id_member` = :id AND SHA1(CONCAT(`passwd`, `password_salt`)) = :cookiepass",
                'params'    => array(':id' => intval($cookie[0]), ':cookiepass' => $cookie[1])
            ));
            
            // fetch the user. if fails -> returs null
            $user = User::model()->find($criteria); 
        }
        
        return $user;
    }
    
    /**
     * @return User new user instance
     */
    private static function createNewUser()
    {
        $user = new User();
        
        $user->member_name= 'tempname_'. rand();
        $user->date_registered = time();
        $user->last_site_visit = time();
        $user->member_ip  = Helpers::getip();
        $user->member_ip2 = Helpers::getip();      
        $user->real_name = '';

        // required empty fields
        $user->buddy_list = '';
        $user->message_labels = '';
        $user->openid_uri = '';
        $user->signature = '';
        $user->ignore_boards = '';
        $user->is_activated = 1;

        $user->passwd         = Helpers::randString(10); 
        $user->password_salt  = Helpers::randString(); 
        
        $user->full_name = '';
        $user->email_address  = 'anonymous@phpguide.co.il';
        $user->is_registered = 0;
        $user->is_blog_admin = 0; 
        
        $user->save();
        
        $user->changeNameAndPass('משתמש_'.$user->id_member);
        return $user;
        
    }
        
    /**
     * Updates user's username and password
     * @param string $newName
     * @param string $newPass
     * @param int $shallRegister  1 to mark as is_registered
     */
    public function changeNameAndPass($newName, $newPass = '', $shallRegister = 0)
    {
        if(empty($newPass)) $newPass = $this->passwd;
        
        $old_name       = $this->member_name;
        $old_pwd        = $this->passwd;
        $old_reg_state  = $this->is_registered;
        
        try
        {
            $this->member_name = $newName;
            $this->passwd =  sha1(mb_strtolower($newName) . $newPass);
            $this->is_registered |= $shallRegister;
            $this->save();
        }
        catch(Exception $e)
        {
            $this->member_name   = $old_name;
            $this->passwd        = $old_pwd;
            $this->is_registered = $old_reg_state;
            
            if(strpos($e->getMessage(), 'Integrity constraint violation: 1062 Duplicate entry') !== false)
            {
                throw new UsernameAlreadyTaken;
            }
            else throw $e;
        }
        
    }
        
        
    
    public function getNewForumPostsCount()
    {
        return 1;
    }
        
    
    
    
    /**
      * Registers the users with his own username and password in the database
      * @param string $username  New user's nickname
      * @param string $pass New user's passowrd
      */
     public function register($username, $pass)
     {
         if( !$this->is_registered ) 
         {
             $this->set_name_pass($username, $pass, 1);
         }
     }

	
     
     
     
     /**
     * Attempts to authorize user checking his login and pass with bruteforce prevention
     * @param string $login
     * @param string $pass
     * @return User logged in user, or string "locked" or false;
     */
    public static function authorize_by_login_and_pass($login, $pass)
    {
        if(self::is_ip_locked(Helpers::getip())) return 'locked';
        
        if( ($user = self::getUserByLoginAndPass($login, $pass)) !==null )
        {
            $user->make_user_current();
            return $user;
        }
        
        // add one to bruteforce counter
        Yii::app()->db
                ->createCommand("INSERT INTO `unauth` (`ip`, `time`) VALUES(:ip, NOW()) ")
                ->execute(array('ip' => Yii::app()->request->userHostAddress))   ;
        
        return null;
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
                   >= 5;

    }

    
    
    /**
     * Returns User instance of the user with the specified login and pass
     * @param string $login nick
     * @param  $pass password
     */
    private static function getUserByLoginAndPass($login, $pass)
    {
        return self::model()
                ->find("member_name = :login AND passwd = :pass", array('login' => $login, 'pass' => sha1(mb_strtolower($login). $pass) ));
    }
     
}



