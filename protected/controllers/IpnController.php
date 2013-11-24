<?php

class IpnController extends PHPGController
{
    public $layout = false;

    public function actionIndex()
    {
        $logger = new Monolog\Logger('ipn logger');
        $logger->pushHandler(new Monolog\Handler\StreamHandler( Yii::app()->basePath.'/runtime/ipn.log' ));

        $certFile = Yii::app()->basePath.'/data/paypal_api_certificate.crt';

        $listener = new IpnListener($certFile);
        $admMail = Yii::app()->params['adminEmail'];
        $paypalOwnerMail = Yii::app()->params['paypalReceiverEmail'];

        $product = 'oopbook';
        $price = Yii::app()->params['products'][$product]['price'];
        $filePath = Yii::app()->params['products'][$product]['pathToFile'];

        $ipn = new Ipn($logger, new Helpers(), $listener, Yii::app()->user->getUserInstance(), $admMail, $paypalOwnerMail);
        $ipn->ProcessIpnRequest($_POST, $price, $product, $filePath);
    }
}