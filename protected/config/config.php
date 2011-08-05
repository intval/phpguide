<?php

/**
 * This is the main application configuration file
 * This settings affect both production and local development releases
 * 
 * @author Alex Raskin (Alex@phpguide.co.il)
 */


// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Phpguide',


	// autoloading model and component classes
	'import' => array
        (
		'application.models.*',
		'application.components.*',
                'application.controllers.*',
                'application.sources.*'
	),


	// application components
	'components'=>array
         (
		'session'       => array( 'autoStart' => true),
		'db'            => include dirname(__FILE__).'/dbconnection.php',
		'errorHandler'  => array( 'errorAction'=>'homepage/error' ),
                'urlManager'    => array
                (
                    'urlFormat'=>'path',
                    'showScriptName'=>false,
                    'rules'=>array
                    (
                        '' => 'homepage/index',
                        '<article_url:[-_\+\sA-Za-z0-9א-ת]+>\.htm'  => 'Article/index',
                        'cat/<cat_url:[-_\+\sA-Za-z0-9א-ת]+>\.htm'  => 'Category/index',  
                        '<controller:[a-z]+>/<action:\w+>'             => '<controller>/<action>',
                        'phplive'                                   => 'Phplive/index',
                                'עיצובים_להורדה' => 'Templates/index',
                            'עיצובים_להורדה/<id:\d+>' => 'Templates/showConcreteTemplate',
                            'עיצובים_להורדה/topframe/<id:\d+>' => 'Templates/topframe',
                                
                    )
		)
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array
        (
		'adminEmail'=>'Alex@phpguide.co.il',
	),
);