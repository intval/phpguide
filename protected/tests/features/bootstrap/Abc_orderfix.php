<?php

/*
 *
 * Behats autoloader traverses this directory in alphabetical order
 * thus if you class relies on another class in this directory,
 * but the relying class is included first - you get an error.
 *
 * This file contains some includes, to make sure they are available to
 * other classes the moment behat loads them.
 */

require_once __DIR__.'/../../bootstrap.php';
require_once __DIR__.'/../../../vendors/composerPackages/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';
require_once __DIR__.'/PhpgMinkSubContext.php';