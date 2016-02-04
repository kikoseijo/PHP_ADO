<?php
session_name('ado.sunnyface.com');
session_start();

$debug = '';

define("DebugMain",'1');
define("WEB_ID",'1');

define("DbName","ado");
define("DbHost","localhost");
define("DbPassword","strongPassword");
define("DbLogin","ado");
define("pathSteps","6");		/// * number of explode stepts to the *
define("RootPath",'/home/ado/public_html/');
define("ClassPath", RootPath .'lib/model/*.class.php');
define ("JWT_SECRET_SERVER_KEY", "tny!!****-^$%@@%/$%DML2b");
