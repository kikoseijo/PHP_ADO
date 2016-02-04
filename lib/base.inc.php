<?php
//db and  general vars
require_once("config.inc.php");

require_once("S.class.php");
require_once("Notification.class.php");


/* SOME HELPER CLASSES */
require_once("base/jwt_helper.php");
require_once("base/lib.html2text.php");
require_once("base/formating.php");
require_once("base/form_style.php");
require_once("base/bootstrap.php");
require_once("base/BannerSlider.php");
require_once("base/images.php");
require_once("base/class.csvreader.php");
require_once("base/files.php");
require_once("base/cookie.php");
require_once("base/date.php");
require_once("base/net.php");
require_once("base/formating.php");
require_once("base/parse.php");
require_once("base/debug.php");

/* UI HELPER CLASSES */
require_once("ui/ui.php");

define ("SiteSlogan","The Sunnyface.com PHP-ADO Framework");
$addJS = '';


function createRandomPassword() { 
    $chars = "ASBCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 
    while ($i <= 7) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 
    return $pass; 
}  







