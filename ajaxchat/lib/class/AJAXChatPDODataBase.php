<?php
/*
 * @package AJAX_Chat
 * @author Alex Raskin
 */

// Class to initialize the MySQL DataBase connection:
class AJAXChatDatabasePDO
{

	private $_connectionID;
	private $_errno = 0;
	private $_error = '';
	private $_dbName;

	public function __construct(&$dbConnectionConfig)
        {
            if( isset ($dbConnectionConfig['link']))     $this->_connectionID = $dbConnectionConfig['link'];
            else if (isset($dbConnectionConfig['name'])) $this->_dbName = $dbConnectionConfig['name'];
	}

	// Method to connect to the DataBase server:
	public function connect(&$dbConnectionConfig)
        { 
            if(! $this->_connectionID )
            {
                try
                {   
                    $this->_connectionID = new PDO($dbConnectionConfig['dsn'],$dbConnectionConfig['user'],$dbConnectionConfig['pass']);
                    $this->_connectionID->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $dbConnectionConfig['link'] = $this->_connectionID;
                    return true;
                }
                catch(PDOException $e)
                {
                    $this->_errno = -1;
                    $this->_error = $e->getMessage();
                    return false;
                }
            }
            return true;
	}

	// Method to select the DataBase:
	function select($dbName)
        {
		// db specified at PDO construction
		return true;
	}

	// Method to determine if an error has occured:
	function error()
        {
		return $this->_connectionID->errorCode() > 0;
	}

	// Method to return the error report:
	function getError() {
		if($this->error()) {
			$str = 'Error-Report: '	.$this->_error."\n";
			$str .= 'Error-Code: '.$this->_errno."\n";
		} else {
			$str = 'No errors.'."\n";
		}
		return $str;
	}

	// Method to return the connection identifier:
	function &getConnectionID() {
		return $this->_connectionID;
	}

	// Method to prevent SQL injections:
	function makeSafe($value) {
		return $this->_connectionID->quote($value);
	}

	// Method to perform SQL queries:
	function sqlQuery($sql) {
		return new AJAXChatPDOQuery($sql, $this->_connectionID);
	}

	// Method to retrieve the current DataBase name:
	function getName() {
		return $this->_dbName;
	}

	// Method to retrieve the last inserted ID:
	function getLastInsertedID() {
		return $this->_connectionID->lastInsertId();
	}

}