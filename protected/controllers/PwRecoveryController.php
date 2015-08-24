<?php
class PwRecoveryController extends PHPGController
{
    /**
     * Password recovery form and validation
     *
     * @return void
     */
    public function actionRecover()
    {
        if(!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->getHomeUrl());

        $this->pageTitle = 'שחזור סיסמה';
        $this->description = 'שחזור סיסמה באתר לימוד PHP';
        $this->keywords = 'שחזור, סיסמה';

        $this->addscripts('login');
        $this->render('passwordRecoveryForm');
    }

    /**
     * Handles submission of the request pw recovery form
     *
     * @return void
     */
    public function actionAjaxRecoverSubmit()
    {
        if(!Yii::app()->user->isGuest)
            return;

        $login = Yii::app()->request->getPost('login');
        $email = Yii::app()->request->getPost('email');

        $recoveryModel = new PasswordRecovery();
        $ip = Yii::app()->request->getUserHostAddress();

        try
        {
            $recoveryResult = $recoveryModel->requestRecovery($login, $email, $ip);
        }
        catch(Exception $e)
        {
            echo 'חלה שגיאה לא מוכרת כלשהי. נסו שוב מאוחר יותר';
            $logmsg = "Password recovery error: " . $e->getMessage();
            Yii::log($logmsg, CLogger::LEVEL_ERROR);
            return;
        }

        switch($recoveryResult)
        {
            case PasswordRecovery::ERROR_INVALID_EMAIL:
                echo 'האימייל שהוזן שגוי';
                break;

            case PasswordRecovery::ERROR_USER_NOT_FOUND:
                echo 'משתמש עם שם כזה לא רשום במערת';
                break;

            case PasswordRecovery::ERROR_NONE:
                echo 'מייל עם הוראות לשחזור סיסמה נשלח לכתובת המייל שלך';
                break;

            default:
                echo 'חלה תקלה במערכת. עמכם הסליחה';
                break;
        }




    }


    /**
     * Action to be called when a user clicks recover password link in the mail
     *
     * @throws CHttpException
     * @return void
     */
    public function actionResetUrl()
    {
        $id = Yii::app()->request->getQuery('id');
        $key = Yii::app()->request->getQuery('key');

        $recoveryResult = PasswordRecovery::model()->recover($id, $key);

        switch($recoveryResult)
        {
            case PasswordRecovery::ERROR_INVALID_KEY:
                throw new CHttpException(404);
                break;

            case PasswordRecovery::ERROR_RECOVER_TIMEOUT:
                $this->actionRecover();
                break;

            case PasswordRecovery::ERROR_NONE:

                $this->addscripts('login');

                Yii::app()->clientScript->registerScript(
                    'homepage',
                    'var homepage_url="'.Yii::app()->homeUrl.'"; ',
                    CClientScript::POS_END
                );

                $this->render('changePassword');
                break;
        }
    }


    public function actionChangepw()
    {
		try
		{
			if(Yii::app()->request->getIsAjaxRequest() && !Yii::app()->user->isguest)
			{
				$password = Yii::app()->request->getPost('pass');
				if(empty($password)) 
				{
						echo 'סיסמה ריקה';
						return;
				}

				$salt = Helpers::randString(22);
				$password = WebUser::encrypt_password($password, $salt);

				User::model()->updateByPk(Yii::app()->user->id, array('password' => $password, 'salt' => $salt));
				Yii::app()->user->setFlash('successPwChange', 'סיסמתך שונתה בהצלחה');
			}
			else
			{
				echo "נסה לבצע שינוי סיסמה מתוך עמוד שינוי הסיסמה";
			}
		}
		catch (Exception $e){
			echo 'שינוי סיסמה נכשל. משהו נשבר :(';
		}
    }
}
