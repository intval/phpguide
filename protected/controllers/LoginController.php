<?php

class LoginController extends Controller
{

    
    
    /**
     * Displays Log-in / Registration form 
     */
    public function actionIndex()
    {
        $return_location = Yii::app()->request->getQuery('redir',   Yii::app()->homeUrl );
        $this->addscripts('jquerytools', 'ui', 'login');

        $this->pageTitle = 'הזדהות לאתר לימוד PHP';
        $this->description = 'עמוד הזדהות וכניסה למערכת';
        $this->keywords = 'הזדהות';
        
        
        if(isset(Yii::app()->session['provider']))
        {
            $provider = Yii::app()->session['provider'];
            $userInfo = $provider->getAttributes();
            $this->render('externalRegistration', array('return_location' => $return_location, 'provider' => $provider->serviceName, 'name' => $userInfo['name']));
        }
        else
        {
            $this->render('form', array('return_location' => $return_location));
        }
        
    }

    
    /**
     * Password recovery form and validation
     */
    public function actionRecover()
    {
    	if(Yii::app()->request->getIsAjaxRequest())
    	{
    		$login = Yii::app()->request->getPost('login');
    		$email = Yii::app()->request->getPost('email');
    		
    		if( '' === trim($login)  ||  '' === trim($email) )
    		{
    			echo 'יש להזין אימייל ושם משתמש כלשהם';
    		}
    		else
    		{
    			try
    			{
    				$user = User::model()->findByAttributes(array('login' => $login, 'email' => $email));
    				if(null === $user)
    				{
    					echo 'לא נמצא משתמש כזה במערכת';
    				}
    				else
    				{
    					$pwr = new PasswordRecovery();
    					$pwr->userid = $user->id;
    					$pwr->ip = Yii::app()->request->getUserHostAddress();
    					$pwr->key = Helpers::randString(20);
    					$pwr->validity = new CDbExpression('DATE_ADD(NOW(), INTERVAL 1 HOUR)');
    					$pwr->save();
    					
    					$recovery_url = bu('login/recoverykey?id='.$pwr->id . '&key='.$pwr->key, true);
    					
    					$mail = $this->renderPartial('recoveryMail', array('username' => $user->login, 'recovery_url' => $recovery_url), true);
    					Helpers::sendMail($user->email, "שחזור סיסמה באתר phpguide", $mail);
    					
    					echo 'מייל עם הוראות לשחזור סיסמה נשלח לכתובת המייל שלך';
    				}
    			}
    			catch(Exception $e)
    			{
    				echo 'חלה שגיאה לא מוכרת כלשהי. נסו שוב מאוחר יותר';
    				Yii::log("Password recovery error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
    			}
    		}
    	}
    	else
    	{
    		
    		$this->pageTitle = 'שחזור סיסמה';
    		$this->description = 'שחזור סיסמה באתר לימוד PHP';
    		$this->keywords = 'שחזור, סיסמה';
    		
    		$this->addscripts('login');
    		$this->render('passwordRecovery');
    	}
    }
    
    
    
    /**
     * Action to be called when a user clicks recover password link in the mail
     */
    public function actionRecoverykey()
    {
    	$id = Yii::app()->request->getQuery('id');
    	$key = Yii::app()->request->getQuery('key');
    	
    	$pwr = PasswordRecovery::model()->with('user')->findByPk($id, '`key`=:key and validity > NOW()', array('key' => $key));
    	
    	if( null === $pwr || null === $pwr->user)
    	{
    		$this->redirect(Yii::app()->homeUrl);
    	}
    	
    	$identity = new AuthorizedIdentity($pwr->user);
    	Yii::app()->user->login($identity, Yii::app()->params['login_remember_me_duration']);
    	
    	$this->addscripts('login');
    	Yii::app()->clientScript->registerScript('homepage', 'var homepage_url="'.Yii::app()->homeUrl.'"; ', CClientScript::POS_END);
    	$this->render('changePassword');
    }
    
    
    public function actionChangepw()
    {
    	if(Yii::app()->request->getIsAjaxRequest() && Yii::app()->user->is_registered)
    	{
    		$password = Yii::app()->request->getPost('pass');
    		if(empty($password)) return;
    		
    		$salt = Helpers::randString(22);
    		$password = WebUser::encrypt_password($password, $salt);
    		
    		User::model()->updateByPk(Yii::app()->user->id, array('password' => $password, 'salt' => $salt));
    		Yii::app()->user->setFlash('successPwChange', 'סיסמתך שונת בהצלחה');    
    	}
    }
    
    /**
     * Regular log-in action, called via ajax submit from the login form.
     * @throws CHttpException 
     */
    public function actionLogin()
    {
        if(!Yii::app()->request->getIsAjaxRequest())
        {
            throw new CHttpException(400, 'This request available via ajax only');
        }
        
        $username = Yii::app()->request->getPost('user');
        $password = Yii::app()->request->getPost('pass');
        
        if(empty($username) || empty($password))
        {
            echo 'שם משתמש או סיסמה שגויים';
        }
        else
        {
            try
            {
                $identity = new DbUserIdentity($username, $password); 
                if($identity->authenticate())
                {
                    Yii::app()->user->login($identity, Yii::app()->params['login_remember_me_duration']);
                    
                    // if authentication takes place after external auth, we want to attach the external Id to the account we are authenticating
                    if(isset(Yii::app()->session['externalAuth']))
                    {
                    	$data = array();
                    	
						foreach(Yii::app()->session['externalAuth'] as $key => $id)
						{
							$data[ ServiceUserIdentity::$service2fieldMap[$key] ] = $id;
						}
							
						                     	
                    	$user = User::model()->updateByPk(Yii::app()->user->id, $data);
                    }
                    
                    echo 'ok';
                }
                else 
                {
                    echo('שם משתמש או סיסמה שגויים');
                }
            }
            catch(BruteForceException $e)
            {
                echo('ביצעתם יותר מדי נסניונות התחברות. נסו שוב בעוד שעה');
            }
            catch(Exception $e)
            {
            	echo 'חלה תקלה בתהליך ההזדהות. נסו שום בעוד כמה דקות';
            	Yii::log("Login error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
            	var_dump($e);
            }
        }
    }
    
    
    
    
    
    
     /**
     * Action to use as a callback to external-provider authentication attempt 
     */
    public function actionExternalLogin()
    {
    	
        if (isset($_GET['service'])) 
        {
            $this->authWithExternalProvider($_GET['service']);
        }
        else
        {
            $this->redirect(array('index'));
        }
    }
    
    
    /**
     * Attempts to authenticate the user using external oAuth provider
     * @param type $providerName 
     */
    private function authWithExternalProvider($providerName)
    {
        $authenticator = Yii::app()->eauth->getIdentity($providerName);

        if($authenticator->authenticate() && $authenticator->isAuthenticated) 
        {
            $this->externalAuthSucceeded($authenticator);
        }
        else
        {
            $this->externalAuthFailed($authenticator);
        }
    }
    
    
    
    /**
     * Called on external Authentication success
     * @param IAuthService $provider 
     */
    private function externalAuthSucceeded(IAuthService $provider)
    {
       $identity = new ServiceUserIdentity($provider) ;
       $data = $provider->getAttributes();
       
       // Did someone use this external ID in the past?
       if($identity ->isKnownUser() && $identity->user->is_registered)
       {
           Yii::app()->user->login($identity, Yii::app()->params['login_remember_me_duration']);
           $this->redirect(array('homepage/index'));
       }
       // external auth succeeded, but we don't know whom do this external ID belongs to
       else
       {
       	
       		$userInfo = $provider->getAttributes();
       		$sessionProviders = Yii::app()->session->get('externalAuth');
       		
       		if(!$sessionProviders) $sessionProviders = array();
       		$sessionProviders[$provider -> serviceName] = $userInfo['id'];
       		Yii::app()->session->add('externalAuth', $sessionProviders);
       		
       		$return_location = Yii::app()->request->getQuery('redir',   Yii::app()->homeUrl );
       		$this->addscripts('jquerytools', 'ui', 'login');
       		
			$this->render('changeNameForm', array('provider' => $provider->serviceName, 'name' => $userInfo['name'], 'return_location' => $return_location));
       }
    }
    
    private function externalAuthFailed(IAuthService $serviceAuthenticator)
    {
        Yii::app()->user->setFlash('externalAuthFail', 'הזדהות באמצעות ' . $serviceAuthenticator->getServiceName() . ' נכשלה');
        $this->redirect(array('login/index'));
    }

    
    
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('homepage/index'));
    }

    
    public function actionRegister()
    {
        $username = Yii::app()->request->getPost('reguser');
        $password = Yii::app()->request->getPost('regpass');
        $email = Yii::app()->request->getPost('regemail');
        
        
        try
        {               
            $user = User::model()->findByPk(Yii::app()->user->id);

            $user->attributes = array('login' => $username, 'password' => $password, 'email' => $email);
            $user->reg_date = new CDbExpression('NOW()');

            $user->salt = Helpers::randString(22);
            if(empty($password)) $password = Helpers::randString(22);
            $user->password = WebUser::encrypt_password($password, $user->salt);
            $user->is_registered = true;

            try
            {
                $user->save();
            }
            catch(CDbException $e)
            {
                throw (false !== mb_strpos($e->getMessage(), 'Duplicate') ) ? new UsernameAlreadyTaken() : $e;
            }
            
            $allErrors = array();
            $errors = $user->getErrors();
            
            if(sizeof($errors) > 0)
            {
                foreach($errors as $fieldErrors)
                {
                    $allErrors = array_merge($allErrors, $fieldErrors);
                }
                echo '— ' . nl2br(e(implode("\r\n — ", $allErrors)));
            }
            else
            {
                $identity = new AuthorizedIdentity($user);
                Yii::app()->user->login($identity, Yii::app()->params['login_remember_me_duration']);
                echo 'ok';
            }
        }
        catch (UsernameAlreadyTaken $e)
        {
            echo  'שם משתמש זה תפוס';
        }
        catch (Exception $e)
        {
            echo 'שגיאת שרת בתהליך ההרשמה. אנה נסו במועד מאוחר יותר';
            Yii::log("Signup error : " . $e->getMessage(), CLogger::LEVEL_ERROR);
        }
        

    }

}


/**
 * Indicates the authentication attempt has been blocked to avoid brute-force 
 */
class UsernameAlreadyTaken extends Exception{}