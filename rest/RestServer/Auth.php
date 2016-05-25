<?php
//$inputData = json_decode(file_get_contents('php://input'));  //get user from 
class Auth
{
	
	var $token;
	
	function __construct($token) {
  	$this->token = JWT::decode($token, JWT_SECRET_SERVER_KEY,false); 
	}

	function userID(){
		return $this->token->id;
	}
	
	function isValid(){
		return $this->userID() > 0 ;
	}
}