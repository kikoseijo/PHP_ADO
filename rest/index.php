<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);
ini_set('display_errors', 1);

/*
header('content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Content-Length');
header('Access-Control-Expose-Headers: Accept-Ranges, Content-Encoding, Content-Length, Content-Range');
*/
/*Librearias y clases */
require __DIR__.'/../admin/lib/base.inc.php';
require __DIR__.'/RestServer/RestServer.php';
require __DIR__.'/RestServer/Message.php';
require __DIR__.'/RestServer/Auth.php';

/*Controladores de la applicacion */

$s = new Session(false);
$msg = new Message();

require 'SessionController.php';
require 'ConfigController.php';

spl_autoload_register();
$server = new \RestServer\RestServer('debug');
$server->addClass('SessionController');
$server->addClass('ConfigController', 'getConfig');
$server->handle();

/*
$auth = new Auth(KIKOS_TOKEN);
if ($auth->isValid())
    echo 'Success';
*/

/*
echo json_encode($msg);
echo json_encode($_GET);
echo json_encode($_POST);
echo json_encode($_SERVER);
*/
