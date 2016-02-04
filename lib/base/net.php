<?php

if(!function_exists('checkdnsrr')){
	function checkdnsrr($hostName, $recType = '')
	{
		if(!empty($hostName)) {
			if( $recType == '' ) $recType = "MX";
			exec("nslookup -type=$recType $hostName", $res);
			// check each line to find the one that starts with the host
			// name. If it exists then the function succeeded.
			foreach ($res as $line) {
				if(eregi("^$hostName",$line)) {
					return true;
				}
			}
			// otherwise there was no mail handler for the domain
			return false;
		}
		return false;
	}
}

function httpsPost($Url, $strRequest){
   $ch=curl_init();
   curl_setopt($ch, CURLOPT_URL, $Url);
   curl_setopt($ch, CURLOPT_POST, 1) ;
   curl_setopt($ch, CURLOPT_POSTFIELDS, $strRequest);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // no mostrar en pantalla el resultado
   $res = curl_exec($ch);
   curl_close($ch);
   return $res;
}


function check_email_mx($email) { 
    	if( (preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $email)) || 
    		(preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/',$email)) ) { 
    		$host = explode('@', $email);
    		//if(checkdnsrr($host[1].'.', 'MX') ) return true;
    		//if(checkdnsrr($host[1].'.', 'A') ) return true;
    		//if(checkdnsrr($host[1].'.', 'CNAME') ) return true;
			 return true;
    	}
    	return false;
}


function redirectToHTTPS(){
  if($_SERVER['HTTPS']!="on")  {
     $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
     header("Location:$redirect");
  }
}





