Short HowTo
=============

This is the source code of phpguide.co.il web site.

*[git video](http://phpguide.co.il/%D7%9E%D7%94+%D7%96%D7%94+git.htm)* explaining what GIT is

*[2nd video]()* Covers installations steps and your first commit

Installation
------------

- Download [YiiFramework](http://www.yiiframework.com/)

- Extract the Yii archive and copy "framework" directory to you server

- Download [this code](https://github.com/intval/phpguide/zipball/master) and put it on your server


Database Setup
--------------

- Go to `protected/config/`

- Make a *COPY* of `dbconnection.example.php` and rename it into `dbconnection.php`

- Make a *COPY* of `localize.example.php` as `localize.php`

- Update `dbconnection.php` with your database connection info

- Adjust the path to the framework directory in `locilize.php`

If you put "framework" directory in public_html - it should be somethig like

  `$conf['params']['PATH_TO_YII'] = dirname(__FILE__).'/../../framework';`

- Import DB.SQL via PHPMyAdmin


What's next
-----------

Help available at [phpguide forum](http://phpguide.co.il/forum/)

Write your code, push it and help building the community.

Thanks ;)