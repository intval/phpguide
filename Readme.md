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

Requirments
-----------

- MySQL > 5.1

- PHP > 5.4.8

- *short_open_tags On* !!!!!

Database Setup
--------------

- Go to `protected/config/`

- Make a *COPY* of `dbconnection.example.php` and rename it into `dbconnection.php`

- Make a *COPY* of `local_config.example.php` as `local_config.php`

- Make a *COPY* of `services.example.php` as `services.php`

- Update `dbconnection.php` with your database connection info

- Set write permissions for `protected/runtime`, `protected/assets`

- Adjust the path to the framework directory in `local_config.php`

If you put "framework" directory in public_html - it should be somethig like

  `$conf['params']['PATH_TO_YII'] = dirname(__FILE__).'/../../framework';`

- Import protected/data/DB.SQL via PHPMyAdmin 

- Apply YII migrations. on windows do:
	`cd C:\path\to\phpguide\protected`
	`yiic.bat migrate`
	
- Install composer packages
On unix:
		`cd protected/vendors`
		`curl -s https://getcomposer.org/installer | php` to get composer
		`php composer.phar install -o` to run it.
On windows:
		Download  (composer installer)[https://getcomposer.org/Composer-Setup.exe]
		Open the `protected/vendors` directory in CMD
		type in `composer install -o`
	
	
	
Go to the website. Username: **admin**, pass: **admin**


What's next
-----------

Help available at [phpguide](http://phpguide.co.il/)

Write your code, push it and help building the community.

Thanks ;)


This software is distributed under the BSD Licence
----------------------------------------

Copyright (c) 2012, Alexander Raskin
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the
      documentation and/or other materials provided with the distribution.
    * Neither the name of the <organization> nor the
      names of its contributors may be used to endorse or promote products
      derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
