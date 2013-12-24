<?php

$basepath = __DIR__;
$config = require __DIR__.'/config.prod.php';
unset($basepath);
return $config;