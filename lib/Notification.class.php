<?php

class Notification
{
	var $status;
	var $text;

   function Notification($status, $text) {
   	$this->status = $status;
   	$this->text = $text;
   }
}
