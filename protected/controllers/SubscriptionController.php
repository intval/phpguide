<?php

class SubscriptionController extends PHPGController
{
    public $layout = false;

    public function actionSubscribe()
    {
        $this->layout = false;

        $name  = Yii::app()->request->getPost('name');
        $email = Yii::app()->request->getPost('email');

        // todo, move logic to BL model after merging branch supporting BL

        $status = $this->subscribe($name, $email);
        $response = new StdClass();

        switch($status)
        {
            case self::INVALID_NAME:
                $response->status = false;
                $response->text = 'שם פרטי צריך להיות בעברית';
                break;

            case self::INVALID_EMAIL:
                $response->status = false;
                $response->text = 'משהו לא בסדר עם כתובת האימייל. בדוק אותה';
                break;

            case self::SUCCESS:
                $response->status = true;
                $response->text = 'מעולה, נרשמת בהצלחה';
                break;

            case self::ALREADY_SUBSCRIBED:
                $response->status = false;
                $response->text = 'אתה כבר רשום לרשימת התפוצה';
                break;

            default:
                $response->status = false;
                $response->text = 'קרתה שגיאה טכנית כלשהי. נסה שוב מאוחר יותר';
                break;
        }

        header('Content-type: application/json');
        echo CJSON::encode($response);
        Yii::app()->end();
    }


    const INVALID_NAME  = 1156456;
    const INVALID_EMAIL = 9613236;
    const TECHNICAL_ERROR = 6547823;
    const COULDNT_SUBSCRIBE = 88984121;
    const ALREADY_SUBSCRIBED = 35789400;
    const SUCCESS = 45678913;

    private function subscribe($name, $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            return self::INVALID_EMAIL;

        if(!filter_var($name, FILTER_VALIDATE_REGEXP, [ 'options' => ['regexp' => '#^[a-zא-ת\s]{2,15}$#iu']]))
            return self::INVALID_NAME;

        $mailchimpApiKey = Yii::app()->params['mailchimpApiKey'];
        $mailchimpListId = Yii::app()->params['mailchimpListId'];

        if(empty($mailchimpApiKey) || empty($mailchimpListId))
            return self::TECHNICAL_ERROR;

        $mailchipm = new Mailchimp($mailchimpApiKey);

        try
        {
            $status = $mailchipm->lists->subscribe($mailchimpListId, ['email' => $email], ['NAME' => $name, 'FNAME' => $name]);
            if($status)
            {
                $conf = ['expire' => (new SDateTime('+5 year'))->getTimestamp(), 'httpOnly' => false];
                Yii::app()->request->cookies['SubscribedToMails'] = new \CHttpCookie('SubscribedToMails', $email, $conf);

                /** @var $user User */
                if(!Yii::app()->user->isGuest)
                {
                    $user = Yii::app()->user->getUserInstance();
                    if(null !== $user)
                    {
                        $user->hasMailSubscription = true;
                        $user->real_name = $name;
                        $user->update(['hasMailSubscription', 'real_name']);
                    }
                }
                return self::SUCCESS;
            }
            else
                return self::COULDNT_SUBSCRIBE;
        }
        catch(Mailchimp_List_AlreadySubscribed $e)
        {
            return self::ALREADY_SUBSCRIBED;
        }
        catch(\Exception $e)
        {
            var_dump($e);
            Yii::log($e->getMessage(), CLogger::LEVEL_WARNING);
            return self::COULDNT_SUBSCRIBE;
        }

    }


    public function actionApprove()
    {
        $this->layout = false;
        $this->render('approve');
    }
} 