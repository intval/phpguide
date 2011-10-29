<?php

class LoginController extends Controller
{
    public function actionIndex()
    {
        $return_location = isset($_GET['redir']) ? urldecode($_GET['redir']) : Yii::app()->homeUrl ;
        $this->addscripts('ui');
        $this->render('//homepage/loginpage', array('return_location' => $return_location));
    }


    public function actionLogin()
    {
        $result = User::authorize_by_login_and_pass($_POST['login'], $_POST['pass']);

        if( $result instanceof User )
        {
            echo('ok');
        }
        else if( $result == 'locked')
        {
            echo('ביצעתם יותר מדי נסניונות התחברות. נסו שוב בעוד שעה');
        }
        else if( $result === null )
        {
            echo('שם משתמש או סיסמה שגויים');
        }
        else
        {
            echo('System error');
        }
    }

    public function actionLogout()
    {
            User::get_current_user()->logout();
            $this->redirect(Yii::app()->homeUrl);
    }

    public function actionRegister()
    {
        if(mb_strlen($_POST['user']) > 15)
        {
            echo ':err:' , 'אנה בחרו שם משתמש קצר יותר';
        }
        else if( empty($_POST['user']) || empty($_POST['pass']))
        {
            echo ':err:' , 'לא הוזנו שם משתמש וסיסמה';
        }
        else
        {
            try
            {
                if( 0 === mb_strpos($_POST['user'], 'משתמש_') )
                {
                    throw new UsernameAlreadyTaken;
                }

                // On failure this one throws UsernameAlreadyTaken either
                User::get_current_user()->changeNameAndPass($_POST['user'], $_POST['pass'], 1);
            }
            catch (UsernameAlreadyTaken $e)
            {
                echo ':err:' , 'שם משתמש זה טפוס';
            }
        }

    }
}