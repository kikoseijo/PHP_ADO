<?php

class Config
{
	var $id;
	
	var $name;
	var $email;
	var $address;
	var $phone;
	var $mobile;
	
	var $google_maps;
	var $google_analytics;
	var $google_geo_coors;
	
	var $debug_select;
	var $debug_save;
	var $debug_update;
	var $debug_delete;	
	
	var $creation_date;	
	var $modification_date;	
	
	
	function getName($key){
		if($key=='list')	return 'Listado de Configuración';
		elseif($key=='new')	return 'Nueva Configuración';
		elseif($key=='edit')	return 'Editando Configuración general';
		else return 'Configuración general';
	}
	
	function create_table(){
		return "CREATE TABLE `config` (
				  `id` int(10) NOT NULL auto_increment,
				  `name` varchar(100)  ,
				  `email` text  ,
				  `address` text  ,
				  `phone` varchar(100)  ,
				  `google_maps` text  ,
				  `google_analytics` text  ,
				  `google_geo_coors` varchar(100)  ,
				  `mobile` varchar(45)  ,
				  `debug_select` tinyint(1) ,
				  `debug_save` tinyint(1) ,
				  `debug_update` tinyint(1) ,
				  `debug_delete` tinyint(1) ,
				  `creation_date` datetime,
				  `modification_date` datetime,
				  PRIMARY KEY  (`id`)
				)  ENGINE=MyISAM DEFAULT CHARSET=utf8";
	}

	

	
}
