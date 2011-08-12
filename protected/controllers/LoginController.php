<?php

class LoginController extends Controller
{
	public function actionIndex()
	{
            if(isset($_GET['redir'])) 
            {
                $return_location = urldecode($_GET['redir']);
            }
            else
            {
                $return_location = 'index.php';
            }
            
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
        
        
        /**
         * Logs user out of the system
         */
        public function actionLogout()
        {
                User::get_current_user()->logout();
                $this->redirect("../index.php");
        }
        
        /*
         * Rigsters the user according to post[user] and post[pass] provided
         */
        public function actionRegister()
        {
            if(!empty($_POST['user']) and !empty($_POST['pass']))
            {
                try
                {
                    if( 0 === mb_strpos($_POST['user'], 'משתמש_') )
                    {
                        throw new UsernameAlreadyTaken;
                    }
                    
                    // If fails due to taken username -> throws an exception
                    User::get_current_user()->changeNameAndPass($_POST['user'], $_POST['pass'], 1);
                }
                catch (UsernameAlreadyTaken $e)
                {
                    echo ':err:' , 'שם משתמש זה טפוס';
                }
            }
            else
            {
                echo ':err:' , 'לא הוזנו שם משתמש וסיסמה';
            }
        }
}