<?php


// Config path
$config = include __DIR__.'/config/config.php';

// has a function to adjust config for local env
require __DIR__.'/config/local_config.php';

require_once($config['params']['PATH_TO_YII'].'/yiic.php');

