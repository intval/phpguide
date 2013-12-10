<?php

class OopbookController extends PHPGController
{
    public $layout = '//oopbook/layout';

    public function actionIndex(){

        Yii::app()->clientScript->registerScript('userInfo', 'StartAnalytics("oopbook")', CClientScript::POS_READY);
        $this->render('index');
    }

    public function actionSuccess()
    {
        $this->render('success', ['email' => '']);
    }

    public function actionCancel()
    {
        $this->redirect('index');
    }
}