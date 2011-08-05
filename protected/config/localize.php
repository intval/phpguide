<?php

/**
 * Add any configuration info to the main conf array
 * which will affect the LOCAL application run ONLY.
 * Changes that shall affect the production release should be made in the main conf file
 * 
 * @param array $conf  reference to the configuration array
 * @author Alex Raskin (Alex@phpguide.co.il)
 */
function localize_config(&$conf)
{
    $conf['modules']['gii'] = array
    (
            'class'     => 'system.gii.GiiModule',
            'password'  => 'qwerty',
            'ipFilters' => array('127.0.0.1','::1'),
    );
    
    // add logging in development env
    $conf['preload'][] = 'log';
    
    // error logging
    $conf['components']['log'] = array
    (
        'class'=>'CLogRouter',
        'routes'=>array(
                array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error, warning',
                ),
                // uncomment the following to show log messages on web pages     
                /*
                array(
                        'class'=>'CWebLogRoute',
                )
                */
                
        )
    );
}