<?php

class Message
{
	var $error;	//	Código de error
	var $status;	//	Estado Success / Error
	var $text;	// 	Mensaje

   function Message($error, $status, $text) {
   	$this->status = $status;
		$this->error = $error;
   	$this->text = $text;
   }
}
