<?php


function printR($algo){
	echo '<pre>';
	print_r($algo);
	echo '</pre>';
}

function printAll(){
	echo '<pre>';
	print_r($_POST);
	print_r($_GET);
	print_r($_SESSION);
	echo '</pre>';
}

define("LOGS_PATH",'/homez.569/airzone/airlogs/');


function readLogs($file_name='log'){
	ob_start();
	$fh = fopen(LOGS_PATH . $file_name . WEB_ID .'.txt','r');
	while ($line = fgets($fh)) {
		 echo $line ;
	}
	fclose($fh);
	$log = ob_get_contents();
	ob_end_clean();
	return $log;
}


/*funcion para un log de la accion*/
function loggerEmpty($archivo_name='log'){
	global $s;
	$origen = LOGS_PATH . $archivo_name . WEB_ID . ".txt";
	$destino = LOGS_PATH . $archivo_name . WEB_ID . ".tmp";
	$log_activo=1;
	$tiempo_espera = 1;
	if ($log_activo==1)	{
		while (!file_exists($origen)){
			sleep($tiempo_espera);
		}
		rename($origen ,$destino);
		$fp = fopen($destino,"w");
		fwrite($fp,date("d-m H:i")." ; Logs borrados por ".$s->user->name.";\n");
		fclose($fp);
		rename($destino,$origen );	
	}
	return "";
}

/*funcion para un log de la accion*/
function loggerCron($linea){
	$origen = LOGS_PATH ."logCron".WEB_ID.".txt";
	$destino = LOGS_PATH ."logCron.tmp";
	writeLog($origen,$destino,$linea);
}

function loggerLogin($linea){
	$origen = LOGS_PATH ."logLogin".WEB_ID.".txt";
	$destino = LOGS_PATH ."logLogin".WEB_ID.".tmp";
	writeLog($origen,$destino,$linea);
}

function loggerRecordatorios($linea){
	$origen = LOGS_PATH ."logRecordatorio".WEB_ID.".txt";
	$destino = LOGS_PATH ."logRecordatorio".WEB_ID.".tmp";
	writeLog($origen,$destino,$linea);
}

/*funcion para un log de la accion*/
function logger($linea){
	$origen = LOGS_PATH ."log".WEB_ID.".txt";
	$destino = LOGS_PATH . "log".WEB_ID.".tmp";
	writeLog($origen,$destino,$linea);
}

function writeLog($origen,$destino,$linea){
	$log_activo=1;
	$tiempo_espera = 1;
	if ($log_activo==1)	{
		while (!file_exists($origen)){
			sleep($tiempo_espera);
		}
		rename($origen ,$destino);
		$fp = fopen($destino,"a");
		if ($_SERVER['SERVER_ADDR']<>'') $mas_info=$_SERVER['SERVER_ADDR']." ; ";
		fwrite($fp,date("d-m H:i")." ; ".$mas_info.$linea."\n");
		fclose($fp);
		rename($destino,$origen);	
	}
}




