<?php

return array
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
    'twitter' => array(
        // register your app here: https://dev.twitter.com/apps/new
        'class' => 'TwitterOAuthService',
        'key' => '...',
        'secret' => '...',
    ),  
    
    /* The rest do not apply to phpguide
     
     
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
);