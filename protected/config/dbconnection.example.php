<? 
/**
 * This file contains your DB connection info. Feel free to modify it according to your needs
 * it's not supposed to be commited or uploaded.
 * @author Alex Raskin (Alex@phpguide.co.il)
 */

$GLOBALS['db_connection_config'] = array
(
	'connectionString' => 'mysql:host=localhost;dbname=YOUR_DATABASE',
        'username' => 'root',
        'password' => '',
    
	'emulatePrepare' => true,
	'charset' => 'utf8',
	'schemaCachingDuration' => 3600,
);