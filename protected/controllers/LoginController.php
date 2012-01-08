<?php

class LoginController extends Controller
{

    
    
    /**
     * Displays Log-in / Registration form 
     */
    public function actionIndex()
    {
        $return_location = Yii::app()->request->getQuery('redir',   Yii::app()->homeUrl );
        $this->addscripts('jquery-tools', 'ui', 'login');

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
       if($identity ->isKnownUser())
       {
           Yii::app()->user->login($identity, Yii::app()->params['login_remember_me_duration']);
           $this->redirect(array('homepage/index'));
       }
       // external auth succeeded, but we don't know whom do this external ID belongs to
       else
       {
           Yii::app()->session['provider'] = $provider;
           $this->redirect(array('login/index'));
       }
    }
    
    private function externalAuthFailed(IAuthService $serviceAuthenticator)
    {
        Yii::app()->user->setFlash('externalAuthFail', 'הזדהות באמצעות ' . $serviceAuthenticator->getServiceName() . ' נכשלה');
        $this->redirect(array('homepage/index'));
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
            if(YII_DEBUG) echo $e->getMessage();
        }
        

    }
    
    private function is_valid_email($mail)
    {
	if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) return false;
	$host = explode("@",$mail); $mxarr = array();
	if (!getmxrr($host[1],$mxarr)) return false;
	return true;
    }
}


/**
 * Indicates the authentication attempt has been blocked to avoid brute-force 
 */
class UsernameAlreadyTaken extends Exception{}