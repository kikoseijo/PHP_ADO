<?php

class Sessiones
{
	var $id;
	var $ip;
	var $user;
	var $company;
	var $page;
	var $hora;
	var $conected_from;
	var $web_id;
	var $referer;
	
	
	function getName($key){
		if($key=='list')	return 'Listando Sesiones';
		elseif($key=='new')	return 'Nueva Sesion';
		elseif($key=='edit')	return 'Editando Sesion';
		else return 'Sesiones';
	}
	
	
	function getTable($res,$width='850',$obj=''){
		$extra_table_attr = array('width'=>$width);
		$tbl = new HTML_Table(get_class($this), 'display', 0, 0, 2, $extra_table_attr); 
		$frm = new HTML_Form();
		$kk_trick=array();
		$tbl->addRow('',$kk_trick,'<tfoot>'); 
		$tbl->addCell(tableFooter($obj), NULL, 'data',array('colspan'=>'5'));
		$tbl->addRow('main_table'); 
		$tbl->addCell($frm->addInput('checkbox', 'checkboxall','',array('class'=>'check-all')), 'first', 'header'); 
		$tbl->addCell('Location', null, 'header');
		$tbl->addCell('Time on site', null, 'header');
		$tbl->addCell('User', null, 'header'); 
		$tbl->addCell('On-Page', null, 'header'); 
		$tbl->addCell('Referer', null, 'header'); 
		$tbl->addCell('', null, 'header');
		if ($res) {
			$objGeoIP = new GeoIP();
			while ($res->fetch($res)) { 
				$objGeoIP->search_ip($res->ip);
				if ($objGeoIP->found()) $country=$objGeoIP->getCountryName(); else $country=$res->ip;
				$check_this=$frm->addInput('checkbox', 'check_row[]',$res->id, array('id'=>'check_row[]'));
				$tbl->addRow($class); 
					$tbl->addCell($check_this); 
					$tbl->addCell('<a href="http://www.geoiptool.com/es/?IP='.$res->ip.'" target="_blank">'.$country.'</a>');
					$tbl->addCell(round(($res->hora - $res->conected_from) /60,2).' Min.');
					$tbl->addCell(($res->user<>'')?$res->user:'<strong>Not Register</strong>');
					$tbl->addCell('<a href="http://www.'.$web->domain.$res->page.'" target="_blank">'.$res->page.'</a>');
					$tbl->addCell('<a href="'.$res->referer.'" target="_blank">'.substr($res->referer,0,20).'</a>');
					$tbl->addCell('<a href="admin-generic-edit.php?id='.$res->id.'&fld='.strtolower(get_class()).'">
									<img src="/template/kadmin/images/icons/pencil.png" alt="Edit" />
									</a>&nbsp;&nbsp;&nbsp;
									<a href="admin-generic-list.php?id='.$res->id.'&fld='.strtolower(get_class()).'&action=delete" 
											onClick="return confirmDel();">
									<img src="/template/kadmin/images/icons/cross.png" alt="Delete" />
									</a>'); 
			}
		}
		return $tbl->display();
	}
		
	
	function create_table(){
		return "CREATE TABLE  `sessiones` (
				  `id` varchar(45) ,
				  `ip` varchar(20)  ,
				  `user` varchar(45) ,
				  `page` varchar(100) ,
				  `hora` int(10) unsigned ,
				  `company` varchar(45),
				  `conected_from` int(11),
				  `web_id` int(11),
				  `referer` varchar(100)
				  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	}
	
	
	
	
	
}