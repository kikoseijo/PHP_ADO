<?php

class User
{
	var $id;
	var $web_id;
	var $company_id;
	
	var $login;			//El login es el email..... 
	var $password;		//El password lleva checho un md5();
	var $role;			//A Administrador C Cliente
	var $role2;			//A Administrador ...
	var $lang;			//es español.... tabla idiomas
	
	var $name;
	var $position;		//Cargo que ocupa en la empresa.
	var $phone;
	var $mobile;
	var $email;
	
	var $mailing;		//si desea recibir mailing 1/0
	
	var $vip;
	var $num_connections;
	var $last_connection;
	var $creation_date;
	var $modification_date;
	
	
	function getName($key){
		if($key=='list')	return 'Listando Usuarios';
		elseif($key=='new')	return 'Nuevo Usuario';
		elseif($key=='edit')	return 'Editando Usuario';
		else return 'Usuarios';
	}
	
	
	
	
	function create_table(){
		return "CREATE TABLE  `user` (
				  `id` int(11) NOT NULL auto_increment,
				  `web_id` int(11)  default '1',
					`company_id` int(4) ,
					
				  `login` varchar(64)   ,
				  `password` varchar(32)   ,
					`role` char(1)   default 'C',
					`role2` varchar(1)  default 'U',
					`lang` varchar(2)  default 'es',
					
				  `name` varchar(60)   ,
				  `position` varchar(60)   ,
				  `phone` varchar(20)   ,
				  `mobile` varchar(20)   ,
				  `email` varchar(128)   ,

				  `num_connections` int(11)  default '0',
				  `last_connection` datetime ,
				  `mailing` tinyint(1)  default '1',
				  `vip` tinyint(1) ,
				  
				  `creation_date` datetime ,
				  `modification_date` datetime ,
				  
				  PRIMARY KEY  (`id`),
				  KEY `login` (`login`),
				  KEY `password` (`password`),
				  KEY `company_id` (`company_id`)
				) ENGINE = MyISAM DEFAULT CHARSET=utf8;
				";
	}
	
	
	function import_data(){	//Username root Password toor ;
		return "INSERT INTO `user` (`id`, `web_id`, `lang`, `role`, `login`, `password`, `name`, `position`, `phone`, `mobile`, `email`, `num_connections`, `last_connection`, `mailing`, `vip`, `role2`, `creation_date`, `modification_date`, `company_id`) VALUES
(1, 1, 'es', 'A', 'root', '".md5('toor')."', 'Super Admin', '', '902-902-902', NULL, 'info@demosite.com', 0, '', 1, 0, 'A', '', '', NULL);";
	}

}
