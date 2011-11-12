<?php

class LoginController extends Controller
{
    public function actionIndex()
    {
        $return_location = isset($_GET['redir']) ? urldecode($_GET['redir']) : Yii::app()->homeUrl ;
        $this->addscripts('ui', 'login');
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
            echo  'אנה בחרו שם משתמש קצר יותר';
        }
        else if( empty($_POST['user']) || empty($_POST['pass']) || empty($_POST['email']))
        {
            echo  'לא הוזנו שם משתמש, סיסמה ואימייל';
        }
	else if(!$this->is_valid_email($_POST['email']))
	{
	    echo 'אנא וודא את כתובת האימייל';
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
		$user = User::get_current_user();
		$user->email_address = $_POST['email'];
		$user->save();
		
		echo 'ok';
            }
            catch (UsernameAlreadyTaken $e)
            {
                echo  'שם משתמש זה טפוס';
            }
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