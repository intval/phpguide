<?php

/**
 * Index file of the hebrew's php-communty website 
 * @link http://phpguide.co.il
 * @author Alex Raskin (Alex@phpguide.co.il)
 * Based on YiiFramework {@link http://yiiframework.com}
 */




/************************************************************************/
/****** ANY CHANGES SHOULD BE APPLIED IN CONFIG/LOCAL_CONFIG.PHP ********/
/************************************************************************/



// determine whether this is production environment
$production = !in_array( $_SERVER['REMOTE_ADDR'] , array('::1', '127.0.0.1'));

// Config path
$config = include dirname(__FILE__).'/protected/config/config.php';


if( !$production )
{
    // remove the following lines when in production mode
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    
    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

    // EVERY CHANGE you'd like to make to the config file which should affect
    // *local application ONLY* - make inside this file.

    // has a function to adjust config for local env
    require dirname(__FILE__).'/protected/config/local_config.php';
}


// use light version in production
require_once($config['params']['PATH_TO_YII'].'/yii'.($production ? 'lite' : '').'.php');
require_once(dirname(__FILE__).'/protected/sources/global_functions.php');
Yii::createWebApplication($config)->run();


