<?php

class IpnController extends PHPGController
{
    protected $layout = false;

    public function actionIndex()
    {
        $logger = Yii::app()->logger;
        $ipn = new Ipn($logger, new Helpers(), new IpnListener());
        $ipn->ProcessIpnRequest($_POST);
    }
}