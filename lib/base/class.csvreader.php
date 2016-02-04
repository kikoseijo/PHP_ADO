<?php

/**
 * Short Desc
 *
 * A basic CSV parsing class that offers much the same functionality of the ADODB Class
 *
 * @package CsvReader
 * @author Jonathan Nichols
 * @version 1.0
 * @copyright 2009-06-10
 * @example csv.php
 */

class CsvReader {

	/**#@+
	 *	@access private
	 *	@var string
	 */
	 
	 
	 
	 var $delimiter = ',';
	 var $file = null;
	 var $field_escape = null;
	 var $line_escape = PHP_EOL;
	/**#@-*/
	
	/**#@+
	 *	@access private
	 *	@var int
	 */
	 var $row_pos = 0;
	/**#@-*/
	
	/**#@+
	 *	@access private
	 *	@var string
	 */
	 var $row_array = array();
	/**#@-*/
	
	/**#@+
	 *	@access protected
	 *	@var string
	 */
	var $filename;
	/**#@-*/
	
	/**#@+
	 *	@access protected
	 *	@var boolean
	 */
	var $EOF = false;
	var $BOF = true;
	/**#@-*/
	
	/**#@+
	 *	@access protected
	 *	@var string
	 */
	var $fields = array();
	var $headings = array();
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@var boolean
	 */
	var $first_row_contains_headings = false;
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return boolean
	 */
	function Execute($filename = null) {
		if (isset($filename)) {
			$this->filename = $filename;
			$this->file = file($filename);
			$this->checkfile();
			$this->processfile();
			return true;
		}
		return false;
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return boolean
	 */
	function __construct($file = null, $first_row_contains_headings = false) {		
		$this->first_row_contains_headings = $first_row_contains_headings;
		if (isset($file)) {
			$this->Execute($file);
			return true;
		}
		return false;
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return void
	 */
	function __set($var = null, $val = null) {
		if (!isset($var)) {return;}
		$this->$var = $val;
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return mixed
	 */
	function __get($var = null) {
		if (!isset($var)) {return;}
		return $this->$var;
	}
	/**#@-*/
	
	/**#@+
	 *	@access private
	 *	@return void
	 */
	 function checkfile( $newline = null, $last_run = false ) {
		if (!isset($newline)){$newline = "\r";}
		if ( (sizeof($this->file) == 1) && ($this->file[0] != "") ) {
			$this->file = split($newline, $this->file[0]);
			$this->line_escape = $newline;
			$this->checkfile("\n");
		}
		if ($last_run) {return;}
		$this->checkfile("\r\n", true);
	}
	/**#@-*/
	
	/**#@+
	 *	@access private
	 *	@return void
	 */
	 function SetRecordPointers() {
		if ( ($this->row_pos == 0) && (sizeof($this->row_array) == 1) ) {
			$this->EOF = true;
			$this->BOF = true;
		}
		
		if ( ($this->row_pos == 0) && (sizeof($this->row_array) > 1) ) {
			$this->EOF = false;
			$this->BOF = true;
		}
		
		if ( ($this->row_pos != 0) && ($this->row_pos != sizeof($this->row_array) - 1) ) {
			$this->EOF = false;
			$this->BOF = false;
		}
		
		if ( ($this->row_pos != 0) && ($this->row_pos == sizeof($this->row_array) - 1) ) {
			$this->EOF = true;
			$this->BOF = false;
		}
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return void
	 */
	function SetDelimiter( $delim ) {
		$this->delimiter = $delim;
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return void
	 */
	function SetFieldEscape( $escape ) {
		$this->field_escape = $escape;
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return void
	 */
	function SetLineEscape( $escape ) {
		$this->line_escape = $escape;
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return string
	 */
	function GetDelimiter( $return = true ) {
		if ($return) {return $this->delimiter;}
		echo $this->delimiter;
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return string
	 */
	function GetFieldEscape( $return = true ) {
		if ($return) {return $this->field_escape;}
		echo $this->field_escape;
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return string
	 */
	function GetLineEscape( $return = true ) {
		if ($return) {return $this->line_escape;}
		echo $this->line_escape;
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return string
	 */
	function GetFileName( $return = true ) {
		if ($return) {return $this->filename;}
		echo $this->filename;
	}
	
	/*
	 * @todo Create a functional metatype, understand more about testing for (int), (string), (float), etc.
	 *
	 */
	 
	/*public function MetaType($var) {
		return gettype($var);
	}*/
	
	/**#@+
	 *	@access private
	 *	@return void
	 */
	 function processfile() {
		foreach($this->file as $row_key=>$row_data) {
			$split_array = explode($this->field_escape . $this->delimiter . $this->field_escape, $row_data);
			if ( ($this->first_row_contains_headings) && ($row_key == 0) ) {
				foreach($split_array as $cell_data) {
					$this->headings[] = trim($cell_data);
				}
			} else {
				$key = $row_key;
				if ($this->first_row_contains_headings) {
					$key = $row_key-1;
				}
				$this->row_array[$key] = array();
				foreach($split_array as $cell_num=>$cell_data) {
					$this->row_array[$key][] = trim($cell_data);
					if ($this->first_row_contains_headings) {
						$this->row_array[$key][$this->headings[$cell_num]] = trim($cell_data);
					}
				}
			}
		}
		$this->fields = $this->row_array[$this->row_pos];
		unset($this->file);
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return void
	 */
	function MovePrevious() {
		$this->row_pos--;
		
		if ($this->row_pos == -1) {
			$this->row_pos = 0;
			$this->SetRecordPointers();
			$this->fields = $this->row_array[$this->row_pos];
			return;
		}
		
		$this->fields = $this->row_array[$this->row_pos];
		
		$this->SetRecordPointers();
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return void
	 */
	function MoveNext() {
		$this->SetRecordPointers();
		if ($this->EOF){return;}
		$this->row_pos++;
		$this->fields = $this->row_array[$this->row_pos];
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return void
	 */
	function MoveFirst() {
		$this->SetRecordPointers();
		$this->row_pos = 0;
		$this->fields = $this->row_array[$this->row_pos];
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return void
	 */
	function MoveLast() {
		$this->SetRecordPointers();
		$this->row_pos = sizeof($this->row_array) - 1;
		$this->fields = $this->row_array[$this->row_pos];
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return int
	 */
	function RecordCount() {
		return sizeof($this->row_array);
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return int
	 */
	function FieldCount() {
		return sizeof($this->fields);
	}
	/**#@-*/
	
	/**#@+
	 *	@access public
	 *	@return string
	 */
	function CreateSqlInsert($table = null, $use_fields = null, $exclude_fields = null) {
		if (!isset($table)) {return false;}
		
		$fields = "";
		$values = "";
		
		if ( (isset($use_fields)) && (is_array($use_fields)) ) {
			foreach($use_fields as $field) {
				$fields .= ", $field";
				$values .= ", '{$this->fields[$field]}'";
			}
		} else {
			if (!isset($use_fields)) {
				if($this->first_row_contains_headings) {
					foreach($this->headings as $key) {
						$addfield = true;
						if (isset($exclude_fields)) {
							foreach($exclude_fields as $exfield) {
								if ($exfield == $key) {
									$addfield = false;
								}
							}
						}
						if ($addfield) {
							$fields .= ", $key";
							$values .= ", '{$this->fields[$key]}'";
						}
					}
				} else {
					foreach($this->fields as $key=>$val) {
						$addfield = true;
						if (isset($exclude_fields)) {
							foreach($exclude_fields as $exfield) {
								if ($exfield == $key) {
									$addfield = false;
								}
							}
						}
						if ($addfield) {
							$fields .= ", $key";
							$values .= ", '{$this->fields[$key]}'";
						}
					}
				}
			}
		}
		
		return "INSERT INTO `$table` (" . ltrim($fields, ", ") . ") VALUES (" . ltrim($values, ", ") . ");";
	}
	/**#@-*/
}
