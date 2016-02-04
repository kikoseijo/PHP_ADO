<?php

require_once("lib/base.inc.php");
$s = new Session(false);
$filName = basename(__FILE__, '.php');

/*SEO*/
$title = 'Login - Access to private area';

if (isset($_POST["user"]) == true) {
   $user = parseField("user");
   $password = parseField("password");
   if ($s->login($user,$password,true,true) > 0) {
		 $s->goToDefaultUrl('/login.php');
   } else {
		 $notification = new Notification("Error",'Usuario y contraseña dont match.');
   }
}

include("parts/header.php");

include("pages/login.php");



$doDebug = parseGet("debug");
if ($doDebug>0){
	echo (isset($debug)) ? $debug : '';
	printR($_POST);
	printR($s);
}


include("parts/footer.php");
