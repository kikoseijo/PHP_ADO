<?php
include("DbResult.class.php");

class DbConnection
{
	var $connection;
	var $errorMsg;
	var $connectError;

	function DbConnection($host, $login, $password, $db) {
        // Make connection to MySQL server
        if (!$this->connection = @mysql_connect($host, $login, $password)) {
            $this->errorMsg = 'Could not connect to server' . "\n";
            $this->connectError = true;
        // Select database
        } else if ( !@mysql_select_db($db, $this->connection) ) {
            $this->errorMsg = 'Could not select database'. "\n";
            $this->connectError = true;
        }
    }
	
	function isError() {
        if ( $this->connectError ) { return true; }
        $this->errorMsg = mysql_error($this->connection);
		if ( empty($this->errorMsg) ) {
            return false;
		} else {
            return true;
		}
    }

	function query($sql) {
		
		$debugsql="select debugmysql from web where id='".WEB_ID."'";
		$data1 = new DbResult(mysql_query($debugsql,$this->connection));
		$data = $data1->fetch_row();
		if ($data[0])
				$GLOBALS["debug"] .=  '<br />DEBUGIN INFO<br />'.$sql.'<br />';
		
	    if (!$res = @mysql_query($sql,$this->connection)) {
            $this->errorMsg = 'Query failed: ' . mysql_error($this->connection) . ' SQL: ' . $sql;
		}
		
	   	if ($res)
	   		return new DbResult($res);
	   	else
	   		return null;
		
	}
	
	
	function q($sql) {
		
		$debugsql="select debugmysql from web where id='".WEB_ID."'";
		$data1 = new DbResult(mysql_query($debugsql,$this->connection));
		$data = $data1->fetch_row();
		if ($data[0])
				$GLOBALS["debug"] .=  'DEBUGIN INFO<br />'.$sql.'<br />';
		
	   if (!$res = @mysql_query($sql,$this->connection)) {
            $this->errorMsg = 'Query failed: ' . mysql_error($this->connection) . ' SQL: ' . $sql;
		}
		
	   if ($res)
	   	return $res;
	   else
	   	return null;
	}
	
	function getErrorMsg() {
		return '<span style="color:red">' . $this->errorMsg . '</span><br />';
	}

	function get_value($sql) {
		$res = $this->query($sql);
		if ($res != null) {
			$data = $res->fetch_row();
			return (empty($data) == false) ? utf8_encode(stripslashes($data[0])) : null;
		}
		else
			return null;
	}

	function insert_id() {
	   return mysql_insert_id();
	}

	function affected_rows() {
	   return mysql_affected_rows();
	}

	function close() {
	   if (isset($this->connection) == true) {
	      mysql_close($this->connection);
	      unset($this->connection);
	   }
	}

	function error() { return mysql_error($this->connection); }
	function errno() { return mysql_errno($this->connection); }
}
