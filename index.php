<?php

/**
 * Index file of the hebrew's php-communty website 
 * @link http://phpguide.co.il
 * @author Alex Raskin (Alex@phpguide.co.il)
 * Based on YiiFramework {@link http://yiiframework.com}
 */




/********************************************************************/
/****** ANY CHANGES SHOULD BE APPLIED IN CONFIG/LOCALIZE.PHP ********/
/********************************************************************/





// determine whether this is production environment
$production = $_SERVER['REMOTE_ADDR'] != '127.0.0.1';

// Config path
$config = include dirname(__FILE__).'/protected/config/config.php';


if( !$production )
{ 
    // remove the following lines when in production mode
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    
    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

    // has a function to adjust config for local env
    require dirname(__FILE__).'/protected/config/localize.php';
    
    // EVERY CHANGE you'd like to make to the config file which should affect
    // *local application ONLY* - make inside this function. Such as enable logging,
    // adding debugging or profiling modules.
    localize_config($config);
}


// use light version in production
require_once($conf['PATH_TO_YII'].'/yii'.($production ? 'lite' : '').'.php');
require_once(dirname(__FILE__).'/protected/sources/global_functions.php');
Yii::createWebApplication($config)->run();
