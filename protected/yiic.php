<?php


// Config path
$config = include __DIR__.'/config/config.php';

// has a function to adjust config for local env
$pathToLocalConfig = __DIR__.'/config/local_config.php';
if(file_exists($pathToLocalConfig))
    require $pathToLocalConfig;


# $config['registerPathAliases']();
unset($config['registerPathAliases']);

require_once($config['params']['PATH_TO_YII'].'/yiic.php');

