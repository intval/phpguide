<?php

class IpnController extends PHPGController
{
    public $layout = false;

    public function actionIndex()
    {
        $logger = new Monolog\Logger('ipn logger');
        $logger->pushHandler(new Monolog\Handler\StreamHandler( Yii::app()->basePath.'/runtime/ipn.log' ));

        $ipn = new Ipn($logger, new Helpers(), new IpnListener());
        $ipn->ProcessIpnRequest($_POST);
    }
}