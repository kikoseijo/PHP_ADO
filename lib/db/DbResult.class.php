<?php

class DbResult
{
   var $res;

   function DbResult($res) {
      $this->res = $res;
   }

   function fetch_row() {
      return mysql_fetch_row($this->res);
   }

   function fetch_object() {
      return mysql_fetch_object($this->res);
   }

   function fetch_assoc() {
      return mysql_fetch_assoc($this->res);
   }

	function fetch(&$obj) {
	   $row = $this->fetch_assoc();
	   if ($row) {
			$i = 0;
			foreach($row as $col => $val)
				$obj->$col = utf8_encode(stripslashes($val));
			return $obj;
	   }
	   else {
	      $this->free();
			return null;
	   }
	}

   function result($i) {
      return mysql_result($this->res,$i);
   }

   function nr() {
      return mysql_num_rows($this->res);
   }
	function num_rows() {
      return mysql_num_rows($this->res);
   }
   function field_table($i) {
      return mysql_field_table($this->res,$i);
   }

   function free() {
      mysql_free_result($this->res);
      unset($this->res);
   }
}

