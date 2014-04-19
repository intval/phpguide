<?php

class ContactController extends \PHPGController
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionSend()
    {
        $mail = trim(\Yii::app()->request->getPost('email'));
        $msg = trim(\Yii::app()->request->getPost('message'));

        if(empty($mail) || empty($msg))
        {
            echo 'err';
            return;
        }

        \Helpers::sendMail([\Yii::app()->params['contactMail']], "site mail from $mail", $msg . "\r\n" . $mail);
        echo 'ok';
    }
} 