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
		'db'            => require 'dbconnection.php',
		'errorHandler'  => array( 'errorAction'=>'homepage/error' ),
                'request'       => array('enableCsrfValidation' => true),
                'user'          => array( 'class' => 'WebUser'),
                'urlManager'    => array
                (
                    'urlFormat'=>'path',
                    'showScriptName'=>false,
                    'rules'=>array
                    (
                        '' => 'homepage/index',
                    	'q<id:\d+>/<subj:[-_\+\sA-Za-z0-9א-ת]+>.htm' => 'qna/view',
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
                    'services' => array
                    (
                        
                        'google' => array(
                            'class' => 'GoogleOpenIDService',
                        ),
                    
                        'facebook' => array(
                            // register your app here: https://developers.facebook.com/apps/
                            'class' => 'FacebookOAuthService',
                            'client_id' => '...',
                            'client_secret' => '...',
                        ),
                        /*
                        'twitter' => array(
                            // register your app here: https://dev.twitter.com/apps/new
                            'class' => 'TwitterOAuthService',
                            'key' => '...',
                            'secret' => '...',
                        ),  
                         
                        'yandex' => array(
                            'class' => 'YandexOpenIDService',
                        ),
                        'google_oauth' => array(
                            // register your app here: https://code.google.com/apis/console/
                            'class' => 'GoogleOAuthService',
                            'client_id' => '...',
                            'client_secret' => '...',
                            'title' => 'Google (OAuth)',
                        ),
                        
                        'vkontakte' => array(
                            // register your app here: http://vkontakte.ru/editapp?act=create&site=1
                            'class' => 'VKontakteOAuthService',
                            'client_id' => '...',
                            'client_secret' => '...',
                        ),
                        'mailru' => array(
                            // register your app here: http://api.mail.ru/sites/my/add
                            'class' => 'MailruOAuthService',
                            'client_id' => '...',
                            'client_secret' => '...',
                        ),
                        'moikrug' => array(
                            // register your app here: https://oauth.yandex.ru/client/my
                            'class' => 'MoikrugOAuthService',
                            'client_id' => '...',
                            'client_secret' => '...',
                        ),
                        'odnoklassniki' => array(
                            // register your app here: http://www.odnoklassniki.ru/dk?st.cmd=appsInfoMyDevList&st._aid=Apps_Info_MyDev
                            'class' => 'OdnoklassnikiOAuthService',
                            'client_id' => '...',
                            'client_public' => '...',
                            'client_secret' => '...',
                            'title' => 'Odnokl.',
                        ),
                        */
                    )
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
            'adminEmail'=>'some1@localhost',
            'login_remember_me_duration' => 31536000,
            
            // used to integrate capybar chat. To register with capybar please wisit http://capybar.com/webmasters2/
            'capybar_api_key' => '',
            
            /******************************************************/
            /**** This is production path, above public_html ******/
            /**** Edit the path in local_config.php, not here******/
            /******************************************************/
            'PATH_TO_YII' => dirname(__FILE__).'/../../../framework',
            /******************************************************/
            /******************************************************/
	),
);
