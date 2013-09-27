<?php


// Config path
$config = include __DIR__.'/../config/test.php';

// has a function to adjust config for local env
$pathToLocalConfig = __DIR__.'/../config/local_config.php';

if(file_exists($pathToLocalConfig))
    require $pathToLocalConfig;




require __DIR__.'/../sources/global_functions.php';
require_once $config['params']['PATH_TO_YII'].'/yiit.php';

$config['registerPathAliases']();
unset($config['registerPathAliases']);


// add composer packages
require __DIR__.'/../vendors/composerPackages/autoload.php';


Yii::createWebApplication($config);


