<?php
if(extension_loaded('xdebug'))
    xdebug_enable();

ini_set('xdebug.show_exception_trace', 0);

// Config path
$config = include __DIR__.'/../config/test.php';

// has a function to adjust config for local env
$pathToLocalConfig = __DIR__.'/../config/local_config.php';

if(file_exists($pathToLocalConfig))
    require $pathToLocalConfig;




require __DIR__.'/../sources/global_functions.php';
require_once $config['params']['PATH_TO_YII'].'/yiit.php';




// add composer packages
require __DIR__.'/../vendors/composerPackages/autoload.php';

Yii::createWebApplication($config);

unset($config);
unset($pathToLocalConfig);



