hi :)

Short HowTo
-----------

1. Download Yii Framework from http://www.yiiframework.com/

2. Extract the archive and copy the "framework" directory to your public_html directory

3. Download the source code from here and put it in your public_html folder

4. Go to protected/config/ dir and copy 2 files as said in the *****README.txt***** file

5. Open protected/config/localize.php and edit the PATH_TO_YII element, to point to the framework directory.
    If you put both your "framework" directory in public_html - it should be somethig like
    $conf['PATH_TO_YII'] = dirname(__FILE__).'/../../framework';

6. Open protected/config/dbconnection.php and change your connections settings

7. Go to phpmyadmin and import the DB.SQL file, which will create all the tables for you.

-----------

Thats all, now you can browse your site.