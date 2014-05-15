<?php

/**
 * This is the main application configuration file
 * This settings affect both production and local development releases
 * 
 * @author Alex Raskin (Alex@phpguide.co.il)
 */

$cacheType = extension_loaded('apc') ?
                'system.caching.CApcCache' : 'system.caching.CFileCache' ;


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
        'ext.eauth.services.*',
        'ext.yii-mail.YiiMailMessage'
	),

    'registerPathAliases' => function()
    {
        $protectedDirPath = realpath(__DIR__.'/../');
        Yii::setPathOfAlias('phpg', $protectedDirPath);
    },

	// application components
	'components'=>array
         (
		'session'       => array( 'autoStart' => true),
		'db'            => require 'dbconnection.php',
		'errorHandler'  => array( 'errorAction'=>'homepage/error' ),
        'request'       => array('enableCsrfValidation' => true),
        'user'          => array( 'class' => 'WebUser'),
        'cache'         => ['class' => $cacheType],
        'urlManager'    => array
        (
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'rules'=> require 'routes.php'
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

        'mail' => array
        (
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'viewPath' => 'application.views.emails',
            'logging' => true,
            'dryRun' => false,

            // Uncomment if you want to use mandrill as well
            /*
            'transportOptions' =>
            [
                'username' => '...',
                'password' => '...',
                'host' => 'smtp.mandrillapp.com',
                'port' => 587
            ]
            */
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
        'contactMail' => 'some1@localhost',
        'login_remember_me_duration' => 31536000,

        // indicates what would be the 'from' address for mails sent by the site
        // email => name ( like:   mysiteBot<noreply@mysite.com> )
        'emailFrom' => ['noreply@mysite.com' => 'mysiteBot'],

        // api key for mailchimp.com
        'mailchimpApiKey' => null,
        'mailchimpListId' => null,

        // paypal
        'paypalReceiverEmail' => 'paypal@email.com',
        'products' => [
            'iceCream' => ['price' => 9.90, 'pathToFile' => '/home/icecream.txt'],
        ],

        /******************************************************/
        /**** This is production path, above public_html ******/
        /**** Edit the path in local_config.php, not here******/
        /******************************************************/
        'PATH_TO_YII' => dirname(__FILE__).'/../../framework',
        /******************************************************/
        /******************************************************/
	),
);
