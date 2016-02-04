<?php
require_once("DbConnection.class.php");

class ADO
{
	var $name;
	var $conn;
	var $debug=true;

	function ADO($name, &$conn) {
		$this->name = $name;
		$this->conn =& $conn;
	}
	
	function setDebug($val) {
		$this->debug = $val;
   }

	function get_columns() {
	   return array_keys(get_class_vars($this->name));
	}

	function get($id) {
		if (empty($id) == false) {
			$res = $this->select("$this->name.id='$id'");
			if ($res != null){
			   $obj = new $this->name;
			   $obj = $res->fetch($obj);
			   $res->free();
			   return $obj;
			}
			else
				return null;
		}
		else
			return null;
	}

	function select($where = "", $order = "") {
		$sql = $this->select_query($where,$order);
		$res = $this->conn->query($sql);
		if ($this->debug) {
			$GLOBALS["debug"] .= '<p><strong>Access Class:</strong> ' . $sql . '</p>' . "\n";
			if ($this->conn->isError()) {
				$GLOBALS["debug"]  .=  $this->conn->getErrorMsg();
				return false;
			}
		}
		
		if ($res && ($res->nr() > 0)) {
			return  $res;
		} else {
			if ($this->debug) {
				$GLOBALS["debug"] .= "<p>No results were found based on the criteria you provided. (where = $where // orderby = $order)</p>";
			}
			return false;
		}
	}

	function get_ancestors() {
      $class = $this->name;
      for ($classes[] = $class; $class = get_parent_class($class); $classes[] = $class);
	   return $classes;
	}

	function select_query($where, $order) {
	   $classes = $this->get_ancestors();
	   $num_classes = count($classes);
      $columns = array_keys(get_class_vars($this->name));
	   if ($num_classes == 1) {
	      $from = $this->name;
	      $col_str = implode(",",$columns);
	   }
	   else {
			for ($i = $num_classes-1; $i >= 0; $i--) {
				$class = $classes[$i];
			   if ($i != $num_classes-1)
			   	$from .= " join $class on $class.id=$root_class.id";
			   else {
			      $root_class = $class;
			      $from = $class;
			   }
			}
	      foreach ($columns as $col) {
	      	if (empty($col_str))
	      		$col_str = ($col != "id") ? $col : "$root_class.$col";
	      	else {
	      		$col_str .= ($col != "id") ? ",$col" : ",$root_class.$col";
	      	}
	      }
	   }
		$sql = "select $col_str from $from";
		if (empty($where) == false)
			$sql .= " where $where";
		if (empty($order) == false)
			$sql .= " order by $order";
		$sql .= ";";
		return $sql;
	}

	function count($where) {
	   $sql = "select count(*) from $this->name where $where;";
	   $count = $this->conn->get_value($sql);
	   return $count;
	}

	function save(&$obj) {
	   if ($obj->id == null)
	   	return $this->insert($obj);
	   else
	   	return $this->update($obj);
	}

	function insert($obj) {
	   $classes = $this->get_ancestors();
	   $num_classes = count($classes);
      for ($i = $num_classes-1; $i >= 0; $i--)
         $this->insert_table($obj,$classes[$i]);
      return $obj->id;
	}

	function insert_table(&$obj, $table) {
		$ccols = array_keys(get_class_vars($table));
		// Solo se especificarán en la inserción los valores no nulos que pertenezcan a la clase.
		foreach($ccols as $col) {
		   $val = $obj->$col;
		   if ($val != null) {
		   	$cols[] = $col;
		   	$vals[] = $val;
		   	if ($col != "id")
		   		$obj->$col = null;
		   }
		}
		if (count($cols) > 0) {
			$col_str = implode(",",$cols);
			$val_str = "'".implode("','",$vals)."'";
			$sql = utf8_decode("insert into $table ($col_str) values ($val_str);");
			$this->conn->query($sql);
			if (!$obj->id)
				$obj->id = $this->conn->insert_id();
			return $obj->id;
		}
		else
			return 0;
	}

	function update(&$obj, $only_set = false) {
		$vars = get_object_vars($obj);
		// Si $only_set es cierto entonces solo se actualizarán los valores no nulos.
		if ($only_set == true) {
			foreach($vars as $col => $val) {
			   if ($val != null)
			   	$vars2[$col] = $val;
			}
		}
		else
			$vars2 =& $vars;
		if (count($vars2) > 0) {
		   $classes = $this->get_ancestors();
		   $num_classes = count($classes);
			for ($i = $num_classes-1; $i >= 0; $i--) {
				$class = $classes[$i];
			   if ($i != $num_classes-1)
			   	$cmd .= " join $class on $class.id=$root_class.id";
			   else {
			      $root_class = $class;
			      $cmd = "update $class";
			   }
			}
			foreach($vars2 as $col => $val) {
			   if ($col != "id") {
				   $val = ($val != null) ? "'$val'" : "null";
				   if (empty($sql) == false)
				   	$sql .= ", $col=$val";
				   else
				   	$sql .= " set $col=$val";
			   }
			}
			$sql = utf8_decode($cmd.$sql." where $root_class.id='$obj->id';");
			$this->conn->query($sql);
			return $obj->id;
		}
		else
			return 0;
	}

	function delete($id) {
	   $sql = "delete from $this->name where id='$id';";
		   return $this->conn->query($sql);
	}
}
