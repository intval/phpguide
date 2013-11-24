<?php

class OopbookController extends PHPGController
{
    public $layout = '//oopbook/layout';

    public function actionIndex(){
        $this->render('index');
    }

    public function actionSuccess()
    {
        $order = Order::model()->findByAttributes(['ip' => Yii::app()->request->getUserHostAddress()], 'time > DATE_SUB(NOW(), INTERVAL 1 DAY)');
        $this->render('success', ['email' => $order !== null ? $order->buyer_email : '']);
    }

    public function actionCancel()
    {
        $this->redirect('index');
    }
} 