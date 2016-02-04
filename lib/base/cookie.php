<?php

function build_cookie($var_array) {
  if (is_array($var_array)) {
    foreach ($var_array as $index => $data) {
      $out.= ($data!="") ? $index."=".$data."|" : "";
    }
  }
  return rtrim($out,"|");
}


function break_cookie ($cookie_string) {
  $array=explode("|",$cookie_string);
  foreach ($array as $i=>$stuff) {
    $stuff=explode("=",$stuff);
    $array[$stuff[0]]=$stuff[1];
    unset($array[$i]);
  }
  return $array;
}


function kCookie($action='list'){  //borrarOrden verValores
	if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	$res='';
	
	$past = time() - 3600;
	
	
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
		$valor =trim($parts[1]);
		
		if ($action=='borrarOrden'){
			if (strpos($parts[0],'_order') !== false) {
				setcookie($name,"",0,'/');
				setcookie($name, null, $past);
				$res .= '<span class="error">  Deleted cookie: '.$name.'</span><br>';
			}
		}elseif ($action=='verValores'){
			$res .= $name.' : ' . $valor .'<br>';
		}else{
			$res .= $name.'<br>';
		}
    }
	return $res;
	}
}







