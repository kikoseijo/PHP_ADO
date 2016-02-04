<?php
require_once("A.class.php");

class Session
{
	var $user;
	var $web;

   function Session($auth = true, $refused_req = true) {
   	global $a;

		if (isset($a) == false)
					$a = new Access;

		$this->getWeb();
		$this->user = new User();
		$this->user = (isset($_SESSION["_user"])) ? unserialize($_SESSION["_user"]) : '';
		$this->saveSessiones();
		
		
		if ($auth == true) {
			if ($this->isAuthenticated() == false) {
				
				$donde_queria_ir = $_SERVER["REQUEST_URI"];
				if (strpos($donde_queria_ir,'ajax_sessiones.php') !== false || strpos($donde_queria_ir,'ajax') !== false ) {
						//echo 'true';
				} else {
					$_SESSION["_redirect_url"] = $donde_queria_ir;
				}
				header("Location: /login.php");
				exit();
			}
			
			if (DebugMain){
				//error_reporting(E_ERROR );
				error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);
				ini_set('display_errors', 1);
			}
			
   	}
   }
	 
   function getWeb() {
		global $a;
		$this->web = $a->web->get(WEB_ID);
		//$_SESSION["_web"] = serialize($this->web);
   }
 
   
 
   
   function saveSessiones() {
   	global $a;
		
   	$ses=new Sessiones;
		$ses->id=session_id();
		$ses->ip=$_SERVER['REMOTE_ADDR'];
		$ses->user= (isset($this->user) && isset($this->user->name)) ? $this->user->name : 'UnRegistered';
		//$ses->company=$a->cart->count("session_id='".session_id()."'");
		$ses->page=$_SERVER['REQUEST_URI'];
		$ses->referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		
		$ses->hora=time();
		$ses->conected_from=time();
		$ses->web_id= (isset($this->web)) ? $this->web->id : WEB_ID;
		$limite = $ses->hora-5*60; // (5 minutos)
   		$a->conn->query("delete from sessiones where hora < '".$limite."'");
		$res = $a->conn->query("select id from sessiones where id = '".$ses->id."'");
		if (isset($res) && $res->nr() > 0){
			$ssql = "update sessiones set hora = '".$ses->hora."', user='".$ses->user."', company='".$ses->company."',page='".$ses->page."' where id = '".$ses->id."'";
			$a->conn->query($ssql);
		}else 
			$a->sessiones->insert($ses);
   }

   function isSuperAdmin() {
      return ($this->user->role == 'A' && $this->user->role2 == 'A');
   }
   function isSubAdmin() { 
      return ($this->user->role == 'A' && $this->user->role2 >0);
   }
	function isSudo() {
      return ($this->user->sudo == true);
   }
   function assertAdmin() {
		if (!$this->isSuperAdmin())
			$this->logoff();
   }
   function assertSubAdmin() {
		if ($this->isSuperAdmin() == false && $this->isSubAdmin() == false)
			$this->logoff();
			
		if  ($this->isSuperAdmin() == false && $this->user->web_id <> WEB_ID )
			$this->logoff();	
   }
	 
	function isAuthenticated() {
		
		if (isset($this->user) &&  $this->user->id > 0){
			return true;
		} else {
			if ($_COOKIE['authToken'] != "") {
			  return $this->authWithToken ($_COOKIE['authToken']);
			} else {
				$token_var=parseGet('authToken');
				if ($token_var<>'')
					return $this->authWithToken ($token_var);
			  else	
					return false;
			}
		}
		
			
	}
	
	function authWithToken ($authToken){
		global $a;
		$token = JWT::decode($authToken, JWT_SECRET_SERVER_KEY);
		if (isset($token) && $token->id>0){	
			$u = $a->user->get($token->id);
			return ($this->login($u->login, $u->password));
		} else { 
			return false;
		}
	}

	function isDemo() {
	   return ($_SESSION['demo'] == true);
	}

	
	function updateNumConnections() {
		global $a;
		$a->conn->query("update user set num_connections=num_connections+1, last_connection=now() where id={$this->user->id};");
		$this->user->num_connections++;
		$_SESSION["_user"] = serialize($this->user);
	}

	function goToDefaultUrl($url) {
		if ($this->isAuthenticated() == true) {
			// = $_SESSION["_redirect_url"];
			
			if (empty($url))
				$url = "/admin.php";
			else
				unset($_SESSION["_redirect_url"]);
		}
		else
			$url = "/login.php?act=noAuth_Jet";
		header("Location: $url");
		exit;
	}
	
	function password($email) {
	   global $a, $text_passreset_mail_body, $text_passreset_mail_subject ;
	   $res = $a->user->select("login='$email' and email='$email'");
		if ($res != null) {
			$clave=createRandomPassword();
			$sql="update user set password='".md5($clave)."' where login='$email' and email='$email'";
			$a->conn->query($sql);
			$res->fetch($tuser);
			
			$asunto= sprintf($text_passreset_mail_subject, $this->web->domain);
			$ip = get_client_ip();
			
			$printIP= '<br /><br />-----------------------<br />Recibido el <b>'.date('d M Y H:i:s').'</b> desde la ip remota <a href="http://geoiptool.com/en/?IP='.$ip.'"><b>'.$ip.'</b></a><br />-----------------------<br /><br />';
			
			require_once('admin/emails/header.php');
			
	    $body = $htmlHeader ;
			$body.= sprintf($text_passreset_mail_body, $tuser->name.' ' . $tuser->surname, $this->web->domain, $clave );
						
			$res="";
			$body.= $htmlFooter;
						
			
			$resultado=mandar_email($asunto,$body,$email,"","","","","0");
			
			return 2;
		}
		else
			return 0;
	}



	function login($login, $password, $remember = true , $rememberp = false) {
	   global $a;
	   		
		if (strlen($password)!=32)
					$password=md5($password);	
							
	   	$res = $a->user->select("login='$login' and password='$password'");
		if ($res != null) {
			$res->fetch($this->user);
			if ($remember == true || $this->user->role=='A') {
			 
				$token = array();
				$token['id'] = $this->user->id;
				$token['email'] = $this->user->email;
				$wToken =  JWT::encode($token, JWT_SECRET_SERVER_KEY);
				$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
				setcookie('authToken', $wToken, time()+60*60*24*365, '/', $domain, false);
				setcookie('_login', $login, time()+60*60*24*365, '/', $domain, false);
			}
			
			$this->updateNumConnections();
			$total_connections = $this->user->num_connections;
			return ++$total_connections;
		}
		else
			return 0;
	}

	function logoff() {
		session_cache_limiter('nocache,private');
		session_name('SunnyFace.com');
		session_start();
		$url = "index.php";
		header("Location: $url");
		session_unset();
		session_destroy();
		$_SESSION = array();
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie(session_name() ,"",0,"/", $domain, false);
		setcookie("authToken","",0,"/", $domain, false);
		//setcookie("_login","",0,"/", $domain, false);
		setcookie("_pass","",0,"/", $domain, false);
		exit;
	}
}

