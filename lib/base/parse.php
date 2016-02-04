<?php

function parseField($name) {
      if (isset($_POST[$name])){
      	$field = stripslashes(trim($_POST[$name]));
		return mysql_real_escape_string($field); 
   }
}

function parseGetField($name) {
      if (isset($_GET[$name])){
      	$field = stripslashes(trim($_GET[$name]));
		return mysql_real_escape_string($field); 
   }
}

function parseGet($name) {
      if (isset($_GET[$name])){
      	$field = stripslashes(trim($_GET[$name]));
		return mysql_real_escape_string($field); 
   }
}
function parsePost($name) {
      if (isset($_POST[$name])){
      	$field = stripslashes(trim($_POST[$name]));
		return mysql_real_escape_string($field); 
   }
}


function parseForm(&$obj, $prefix = "") {
   $vars = array_keys(get_class_vars(get_class($obj)));
	 
   foreach ($vars as $var) {
		 
   	$name = $prefix.$var;
		$theValue = trim($_POST[$name]);
		$valor=str_replace(" & "," &amp; ",$theValue);
      if ($valor<>''){
	  		if (get_magic_quotes_gpc()) { 
					$valor = stripslashes($valor); 
			}  
			$obj->$var = mysql_real_escape_string($valor); 
	  } 
   }
}

function parseObject($obj, $prefix = "") {
   $vars = array_keys(get_class_vars(get_class($obj)));
   foreach ($vars as $var) {
   	$name = $prefix.$var;
	$valor=str_replace(" & "," &amp; ",$obj->$name);

	if (get_magic_quotes_gpc()) { 
			$valor = stripslashes($valor); 
	}  
	$objB->$var = mysql_real_escape_string($valor); 
	
   }
   return $objB;
}

function parseJson(&$obj, $prefix = "") {
	
	$jsonInput=json_decode(file_get_contents('php://input'));  //get user from 
	
   $vars = array_keys(get_class_vars(get_class($obj)));
   foreach ($vars as $var) {
   	$name = $prefix.$var;
		$valor=str_replace(" & "," &amp; ",$jsonInput->$name);
	
		if (get_magic_quotes_gpc()) { 
				$valor = stripslashes($valor); 
		} 
		
		 // despues de hacer la cagada de mostrar el role2 en el role y 
		 // usar role como campo en app 
		 // cualquier usuario que actualizaba su perfil desde la app se convertía en 'A' Airzone.
		 
		if ($valor && $var<>'role')
				$obj->$var = mysql_real_escape_string($valor); 
	
   }
   return $obj;
}



function parseFormNulls(&$obj, $prefix = "") {
   $vars = array_keys(get_class_vars(get_class($obj)));
   foreach ($vars as $var) {
   	$name = $prefix.$var;
	$valor=($_POST[$name]=='')?'0':$_POST[$name];
       
			$obj->$var =$valor; 
	  
   }
}

function TF($campo){
	global $s;
	if ($s->web->$campo) 
		return true;
	else
		return false;
}

function getMetaDescriptionClean($string){
	$new_str = strip_tags($string);
	$string_desc = str_replace(array('<br />','<br >','<br>','<br/>'),' ',$new_str);
	$string_desc = str_replace(PHP_EOL, ' ', $string_desc);
		//PHP_EOL = PHP_End_Of_Line - would remove new lines too
	$string_desc = preg_replace('/[\r\n]+/', " ", $string_desc);
	$string_desc = preg_replace('/[ \t]+/', ' ', $string_desc);
	
	if(strlen($string_desc)>150){
		$pos=strpos($string_desc, ' ', 150);
		$meta_desc = substr($string_desc,0,$pos) . ' ...'; 
	} else {
		$meta_desc = $string_desc;
	}
	
	return $meta_desc;
}

