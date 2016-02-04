<?php

class Web
{
   var $id;
   var $name;
   var $creation_date;
   var $modification_date;
   var $orden;
   var $active;
   
   var $domain;
   var $email;
   var $email_from;
   var $db_name;
   var $db_login;
   var $db_pass;
   var $db_host;
   var $cookie;
   var $orders_ref;
   
   var $category_id;
   var $products_id;
   var $template_id;
   
   var $site_phone;
   var $site_fax;
   var $site_from_user;
   var $operators_email;
   var $admin_email;
	
   
   var $analytics;
   var $mapkey;//maps_url
   
   var $is_on;
   var $ext2;			
   var $ext3;			//Logo
   var $img;			//Logo
   
   
   
   var $debugmysql;
   var $debuglive;
   var $testsite;
   

	function getName($key){
		if($key=='list')	return 'Listando Webs';
		elseif($key=='new')	return 'Nueva Web';
		elseif($key=='edit')	return 'Editando Web';
		else return 'Webs';
	}
   

   
   	function create_table(){
		return "CREATE TABLE  `web` (
				  `id` int(10) unsigned NOT NULL auto_increment,
				  `name` varchar(100) default NULL,
				  `creation_date` datetime default NULL,
				  `modification_date` datetime default NULL,
				  `orden` int(10) unsigned default NULL,
				  `domain` varchar(100) default NULL,
				  `email` varchar(100) default NULL,
				  `email_from` varchar(100) default NULL,
				  `db_name` varchar(45) default NULL,
				  `db_login` varchar(45) default NULL,
				  `db_host` varchar(45) default NULL,
				  `db_pass` varchar(45) default NULL,
				  `cookie` varchar(15) default NULL,
				  `orders_ref` varchar(5) default NULL,
				  `site_phone` varchar(100) default NULL,
				  `site_fax` varchar(100) default NULL,
				  `site_from_user` varchar(100) default NULL,
				  `operators_email` varchar(100) default NULL,
				  `is_on` tinyint(1) NOT NULL default '1',
				  `ext2` varchar(100) default NULL,
				  `ext3` varchar(100) default NULL,
				  `admin_email` varchar(100) default NULL,
				  `debugmysql` tinyint(1) NOT NULL default '0',
				  `debuglive` tinyint(1) NOT NULL default '0',
				  `testsite` tinyint(1) NOT NULL default '0',
				  `active` tinyint(1) NOT NULL default '0',
				  `category_id` int(11) default NULL,
				  `products_id` int(11) default NULL,
				  `img` varchar(45) default NULL,
				  `template_id` int(11) NOT NULL,
				  `analytics` varchar(20),
				  `mapkey` text,
				  PRIMARY KEY  (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	}
	
	
	function import_data(){	
		return "INSERT INTO `web` (`id`, `name`, `creation_date`, `modification_date`, `orden`, `domain`, `email`, `email_from`, `db_name`, `db_login`, `db_host`, `db_pass`, `cookie`, `orders_ref`, `site_phone`, `site_fax`, `site_from_user`, `operators_email`, `is_on`, `ext2`, `ext3`, `admin_email`, `debugmysql`, `debuglive`, `testsite`, `active`, `category_id`, `products_id`, `img`, `template_id`, `analytics`, `mapkey`) VALUES
(1, 'DemoSite', '0000-00-00 00:00:00', '2015-07-28 08:41:58', NULL, 'ado.sunnyface.com', 'info@demosite.es', 'sat@demosite.com', '-', '-', 'ES', '-', NULL, NULL, '(+34) 902 902 902', NULL, 'PHP-ADO SUnnyface.com', 'info@demosite.com', 1, '', NULL, NULL, 0, 0, 0, 1, NULL, NULL, 'logo.png', 0, 'UA-XXXXXXXX-1', '');";
	}
	
   
   
}
