<?php

/**
 * This is the main application configuration file
 * This settings affect both production and local development releases
 * 
 * @author Alex Raskin (Alex@phpguide.co.il)
 */

// Setting the db_connection_config array there
include dirname(__FILE__).'/dbconnection.php';

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    
    
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Phpguide',
	'preload' => array('log'),
    
	// autoloading model and component classes
	'import' => array
        (
		'application.models.*',
		'application.components.*',
                'application.components.identities.*',
                'application.controllers.*',
                'application.sources.*',
                'ext.eoauth.*',
                'ext.eoauth.lib.*',
                'ext.loid.*',
                'ext.eauth.services.*'
	),


	// application components
	'components'=>array
         (
		'session'       => array( 'autoStart' => true),
		'db'            => $GLOBALS['db_connection_config'],
		'errorHandler'  => array( 'errorAction'=>'homepage/error' ),
                'request'       => array('enableCsrfValidation' => true),
                'user'          => array( 'class' => 'WebUser'),
                'log'           => array
                (
                    'class' => 'CLogRouter',
                    'routes' => array
                    (
                        array
                        (
                            'class' => 'CFileLogRoute',
                            'levels' => 'error', 
                            'categories' => '500.*'
                        )
                    )
                ),
                'urlManager'    => array
                (
                    'urlFormat'=>'path',
                    'showScriptName'=>false,
                    'rules'=>array
                    (
                        '' => 'homepage/index',
                        '<article_url:[-_\+\sA-Za-z0-9א-ת]+>\.htm'  => 'Article/index',
                        'cat/<cat_url:[-_\+\sA-Za-z0-9א-ת]+>\.htm'  => 'Category/index',
                        '<controller:[a-z]+>/<action:\w+>'          => '<controller>/<action>',
                        'rss'                                       => 'Homepage/rss'
                    )
                ),
            
                'loid' => array(
                    'class' => 'ext.loid.loid',
                ),
                'eauth' => array(
                    'class' => 'ext.eauth.EAuth',
                    'popup' => false, // Use the popup window instead of redirecting.
                    'services' => require 'services.php',
                ),
                'widgetFactory' => array
                (
                    'widgets' => array
                    (
                        'GravatarWidget' => array
                        (
                            'hashed' => false,
                            'default' => 'identicon',
                            'size' => 20,
                            'rating' => 'g',
                            'htmlOptions' => array('class'=>"right")
                        )
                    )
                )
                
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array
        (
            'adminEmail'=>'Alex@phpguide.co.il',
            'login_remember_me_duration' => 31536000,
            /******************************************************/
            /**** This is production path, above public_html ******/
            /**** Edit the path in local_config.php, not here******/
            /******************************************************/
            'PATH_TO_YII' => dirname(__FILE__).'/../../../framework',
            /******************************************************/
            /******************************************************/
	),
);
