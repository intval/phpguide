<?php


// Config path
$config = include __DIR__.'/../config/test.php';

// has a function to adjust config for local env
$pathToLocalConfig = __DIR__.'/../config/local_config.php';
if(file_exists($pathToLocalConfig))
    require $pathToLocalConfig;


require __DIR__.'/../sources/global_functions.php';
require_once $config['params']['PATH_TO_YII'].'/yiit.php';
require_once __DIR__ . '/PHPGWebTestCase.php';

Yii::createWebApplication($config);
