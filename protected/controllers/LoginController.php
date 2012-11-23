<?php

class LoginController extends PHPGController
{

    /**
     * Displays Log-in page
     *
     * @return void
     */
    public function actionIndex()
    {
        $ret_location = Yii::app()->request->getQuery('redir', Yii::app()->homeUrl);
        $this->addscripts('login');

        $this->pageTitle = 'הזדהות לאתר לימוד PHP';
        $this->description = 'עמוד הזדהות וכניסה למערכת';
        $this->keywords = 'הזדהות';

        $this->render('login', ['return_location' => $ret_location]);
    }


    
    
    /**
     * Regular log-in action, called via ajax submit from the login form.
     * @throws CHttpException 
     */
    public function actionLogin()
    {
        $username = Yii::app()->request->getPost('user');
        $password = Yii::app()->request->getPost('pass');

        if(empty($username) || empty($password))
            return;

        $identity = new DbUserIdentity($username, $password);
        $authStatus = $identity->authenticate();


        switch ($authStatus)
        {
            case DbUserIdentity::ERROR_IP_LOCKED:
                echo 'ביצעתם יותר מדי נסניונות התחברות. נסו שוב בעוד שעה';
                break;

            case CUserIdentity::ERROR_PASSWORD_INVALID:
                echo 'סיסמה שגויה';
                break;

            case CUserIdentity::ERROR_USERNAME_INVALID:
                echo 'שם משתמש שגוי';
                break;

            case CUserIdentity::ERROR_NONE:
                $loginDuration = Yii::app()->params['login_remember_me_duration'];
                Yii::app()->user->login($identity, $loginDuration);
                echo 'ok';
                break;

            default:
                echo 'שגיאה לא מוכרת';

        }

    }
    
    
    
    
    

    
    
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('homepage/index'));
    }

    
    public function actionRegister()
    {
        $username = Yii::app()->request->getPost('reguser');
        $email = Yii::app()->request->getPost('regmail');
        $password = Yii::app()->request->getPost('regpass');
        $externalAuthData = Yii::app()->session['externalAuth'];

        $status = (new User('registration'))->register($username, $email, $password, $externalAuthData);

        if(is_array($status))
        {
            $allErrors = array();

            foreach($status as $fieldErrors)
                $allErrors = array_merge($allErrors, $fieldErrors);

            echo '— ' . nl2br(e(implode("\r\n — ", $allErrors)));
            return;
        }

        switch($status)
        {
            case User::ERROR_USERNAME_TAKEN:
                echo 'שם משתמש זה תפוס';
                break;

            case User::ERROR_NONE:
                echo 'ok';
                break;

            default:
                echo 'שגיאת שרת בתהליך ההרשמה. אנה נסו במועד מאוחר יותר';
                break;
        }
    }

}

