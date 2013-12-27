<?php

/**
 * Index file of the hebrew's php-communty website 
 * @link http://phpguide.co.il
 * @author Alex Raskin (Alex@phpguide.co.il)
 * Based on YiiFramework {@link http://yiiframework.com}
 * @license    BSD Licence as stated in Readme.md
 */




/************************************************************************/
/****** ANY CHANGES SHOULD BE APPLIED IN CONFIG/LOCAL_CONFIG.PHP ********/
/************************************************************************/


if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|less|coffee|sass)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}



// determine whether this is production environment
$localIPs = ['::ffff:127.0.0.1', '::1', '127.0.0.1', '33.33.33.1'];
$production = !in_array( $_SERVER['REMOTE_ADDR'] , $localIPs);

// Config path
$config = require __DIR__.'/protected/config/config.php';


// add composer packages
require __DIR__.'/protected/vendors/composerPackages/autoload.php';
$diEnvironmentConf = 'production';

// fix ip behind incapsula
(new \Intval\IncapsulaIpFixer($_SERVER))->FixRemoteAddrInServerArray();

if( !$production )
{
    // remove the following lines when in production mode
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    
    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

    // EVERY CHANGE you'd like to make to the config file which should affect
    // *local application ONLY* - make inside this file.

    // has a function to adjust config for local env
    require __DIR__.'/protected/config/local_config.php';

    // include local dependency injection configuration
    $diEnvironmentConf='local';
}

// use light version in production
require_once($config['params']['PATH_TO_YII'].'/yii'.($production ? 'lite' : '').'.php');

$config['registerPathAliases']();
unset($config['registerPathAliases']);

require_once(__DIR__.'/protected/sources/global_functions.php');
Yii::createWebApplication($config)->run();


