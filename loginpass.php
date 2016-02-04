<?php
require_once("lib/base.inc.php");
$s = new Session(false);
$title = $s->web->name . " Password reset tool.";


if (isset($_POST["enter"]) == true) {
   $user = $_POST["user"];
   $email = $_POST["email"];
   if ($s->password($email) > 0) {
   		$hecho = true;
   		$s->user->role = "DDDDD";
   }else {
      $notification = new Notification("Error","Email not found.");
   }

}


include("parts/header.php");


//echo md5('pass');
//echo $debug;

include("pages/password.php");

include("parts/footer.php");


