<?php
/*
 * @package AJAX_Chat
 * @author Alex Raskin
 */

// Class to perform SQL (MySQL via PDO) queries:
class AJAXChatPDOQuery
{

	private $_connectionID;
	private $_sql = '';
	private $_result = 0;
	private $_errno = 0;
	private $_error = '';

	// Constructor:
	public function __construct($sql, PDO $connectionID = null)
        {
            $this->_sql = trim($sql);
            $this->_connectionID = $connectionID;

            if($this->_connectionID != null)
            {
                try
                {
                    $this->_result = $this->_connectionID->query($this->_sql);
                }
                catch (PDOException $e)
                {
                    
                    $this->_errno = $this->_connectionID->errorCode();
                    $this->_error = $e->getMessage();
                }
            }
	}

	// Returns true if an error occured:
	function error()
        {
            // Returns true if the Result-ID is valid:
            return $this->_errno > 0;
	}

	// Returns an Error-String:
	function getError()
        {
            if($this->error()) {
                    $str  = 'Query: '	 .$this->_sql  ."\n";
                    $str .= 'Error-Report: ' .$this->_error."\n";
                    $str .= 'Error-Code: '.$this->_errno;
            } else {
                    $str = "No errors.";
            }
            return $str;
	}

	// Returns the content:
	function fetch() {
		if($this->error() || $this->_result === false) {
			return null;
		} else {
                        //var_dump($this);
			return $this->_result->fetch(PDO::FETCH_ASSOC);
		}
	}

	// Returns the number of rows (SELECT or SHOW):
	function numRows() {
		if($this->error() || $this->_result === false) {
			return null;
		} else {
			return $this->_result->rowCount();
		}
	}

	// Returns the number of affected rows (INSERT, UPDATE, REPLACE or DELETE):
	function affectedRows() {
		if($this->error() || $this->_result === false) {
			return null;
		} else {
			return $this->_result->rowCount();
		}
	}

	// Frees the memory:
	function free() 
        {
            if( $this->_result !== false)
		$this->_result->closeCursor();
	}

}
?>