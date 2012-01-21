Short HowTo
=============

This is the source code of phpguide.co.il web site.

*[git video](http://phpguide.co.il/%D7%9E%D7%94+%D7%96%D7%94+git.htm)* explaining what GIT is

*[2nd video](http://phpguide.co.il/git+%D7%9E%D7%A2%D7%A9%D7%99+_+%D7%A2%D7%95%D7%A8%D7%9B%D7%99%D7%9D+%D7%90%D7%AA+phpguide.htm)* Covers installations steps and your first commit

Installation
------------

- Download [YiiFramework](http://www.yiiframework.com/)

- Extract the Yii archive and copy "framework" directory to your server

- Download [this code](https://github.com/intval/phpguide/zipball/master) and put it on your server


Database Setup
--------------

- Go to `protected/config/`

- Make a *COPY* of `dbconnection.example.php` and rename it into `dbconnection.php`

- Make a *COPY* of `local_config.example.php` as `local_config.php`

- Update `dbconnection.php` with your database connection info

- Adjust the path to the framework directory in `local_config.php`

- If you want facebook connect -> create facebook application, *copy * `services.example.php` and rename into `services.php`
  change the appid & appsecret to those of your application and you are good to go.

If you put "framework" directory in public_html - it should be somethig like

  `$conf['params']['PATH_TO_YII'] = dirname(__FILE__).'/../../framework';`

- Import protected/data/DB.SQL via PHPMyAdmin 

- Apply YII migrations. on windows do:
	`cd C:\path\to\phpguide\protected`
	`yiic.bat migrate`
	
Go to the website. Username: admin, pass: admin


What's next
-----------

Help available at [phpguide](http://phpguide.co.il/)

Write your code, push it and help building the community.

Thanks ;)