<?php

class oopbookController extends PHPGController
{
    public $layout = '//oopbook/layout';

    public function actionIndex(){
        $this->render('index');
    }

    public function actionSuccess()
    {
        $order = Order::model()->findByAttributes(['ip' => Yii::app()->request->getUserHostAddress()], 'time > DATE_SUB(NOW(), INTERVAL 1 DAY)');

        if($order === null)
            $this->render('awaiting');
        else
            $this->render('success', ['email' => $order->buyer_email]);
    }

    public function actionCancel()
    {
        $this->redirect('index');
    }
} 