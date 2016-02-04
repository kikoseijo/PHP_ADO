<?php
require_once("db/db.inc.php");
//require_once all the db classes
array_walk(glob(ClassPath),create_function('$v,$i', 'return require_once($v);'));

class Access
{
	var $conn;
	var $Aerror=false;
	var $Amsg;
		
	// We create the first new ADO
   function Access() {
		if (isset($this->conn) == false)
			$this->conn = new DbConnection(DbHost,DbLogin,DbPassword,DbName);
			foreach (glob(ClassPath) as $filename) {
				$pre=explode("/", (string)$filename);
				//echo $filename;
				$class = explode(".", $pre[pathSteps]);

				$thisclass=strtolower($class[0]);
				$this->$thisclass = new ADO($thisclass,$this->conn);
				$this->checkTable($thisclass,$thisclass);
			}
			if ($this->Amsg<>'' || $this->Aerror){
				echo "<script>console.log('" . $this->Amsg . "');</script>";
				echo $this->Amsg;
			}
			
   }

	function getValue($id,$table,$value) {
		$minn=$this->$table->get($id);
		//return utf8_encode(stripslashes($minn->$value));
	   return stripslashes($minn->$value);
	}
	
	function getMultiple($post_name,$union) {
		$array = ($_POST[$post_name]); 
			if ($array) {
				foreach ($array as $key ){
					if ($ri<1) $equip = $key;
					else $equip .=  $union . $key;
					$ri++;
				}
			}
			
		
	   return $equip;
	}
	
	function getSubValues($array_values,$nombre,$table,$delimitador,$union){
	   $equiparray = explode($delimitador,$array_values);
		$equii=0;
			if ($equiparray	){
				foreach ($equiparray as $id){
					$theval=utf8_encode($this->conn->get_value("select $nombre from $table where id='$id'"));
					if ($theval<>''){
						if ($equii<1)
							$extras .= $theval;
						else
							$extras .= $union.' ' .  $theval;
						$equii++;
					}
				}
			}
		return $extras;
   }
	
	function checkTable($tablename,$classee){
	  // global $classee;
	   $sql="SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".DbName."' AND table_name = '$tablename'";
	   if (!$this->conn->get_value($sql)>0){
		   $this->Aerror=true;
		   $classe=ucwords($tablename);
		   $this->Amsg .="Table $classe does not exist in Database.<br />";
		   if (method_exists($tablename,'create_table')){
				$q=new $classe();
				$this->conn->query($q->create_table());
				
				if (method_exists($tablename,'import_data'))
					$this->conn->query($q->import_data());
				
				if ($this->conn->isError()) {
					$this->Amsg .=$this->conn->getErrorMsg();
				}else
					$this->Amsg .="Table  $classe was created form Class Method.<br />";
			}
		   
	   }
	   
		 
	   
   }
   
   
   function saveFile($file, $path, $folder) {
      global $s, $ThumbnailImage;
	  $directorio=FilesDir.$folder."/";
	  //echo $directorio;
      if (is_uploaded_file($path)) {
      	if (($file->filename) && (is_file($directorio.$file->filename)))
      	   unlink($directorio.$file->filename);
		   $file->filename = $file->type.time().".".substr(strrchr($file->filename,"."),1);
			mkdir_recursive($directorio, 0755);
			  $ti = new ThumbnailImage ( );
			  $ti->src_file = $path;
			  $ti->dest_type = THUMB_JPEG;
			  $ti->dest_file = $directorio.'thum150-'.$file->filename;
			  $ti->max_width = 150;
			  $ti->max_height = 150;
			  $ti->Output ( );
			  chmod( $ti->dest_file,0755);
			  $ti->dest_file = $directorio.'thum300-'.$file->filename;
			  $ti->max_width = 300;
			  $ti->max_height = 300;
			  $ti->Output ( );
			  chmod( $ti->dest_file,0755);
			  $ti->dest_file = $directorio.'thum800-'.$file->filename;
			  $ti->max_width = 800;
			  $ti->max_height = 800;
			  $ti->Output ( );
			  chmod( $ti->dest_file,0755);
	      
		  
		  return $file->filename;
      
      
   } 		}

function saveImg($file, $path, $folder) {
      global $s;
		$directorio=RootPath.FilesDir.$folder."/";
      if (is_uploaded_file($path)) {
      	if (($file->filename) && (is_file($directorio.$file->filename)))
      	    unlink($directorio.$file->filename);
			$file->filename = $file->type.time().".".substr(strrchr($file->filename,"."),1);
			mkdir_recursive($directorio, 0755);
	      if ((move_uploaded_file($path, $directorio.$file->filename))){
		  chmod( $directorio.$file->filename,0755);
		  return $file->filename;
      }
      return null;
   }
}
function saveWebLogo($file, $path, $folder,$img_name) {
      global $s;
		$directorio=RootPath.FilesDir.$folder."/";
      if (is_uploaded_file($path)) {
      	if (($file->filename) && (is_file($directorio.$file->filename)))
      	   unlink($directorio.$file->filename);
			mkdir_recursive($directorio, 0755);
			
			if($img_name<>''){
				$file->filename = $img_name.'-'.$file->filename;
			} 
			
	      if ((move_uploaded_file($path, $directorio.$file->filename))){
		  chmod( $directorio.$file->filename,0755);
		  return $file->filename;
      }
      return null;
   }
}   
function getCombo($nombre, $table,$comparo='',$where='',$orden='' ,$valor='id',$css='',$muestra='') {
			$combo= '<select name="'.$nombre.'" id="'.$nombre.'" '.$css.'>';
			
   			$cat=$this->$table->select("active='1' ".$where,$orden);
			echo $verdebug;
			
			//$combo.= '<option> -- Select -- </option>';
				if ($cat>0){ 
				while ($cat->fetch($cat)){
				$ver = ($muestra<>'')?$cat->$muestra  :$cat->name;
				  $combo.= '<option value="'.$cat->$valor.'"';
				  if ($cat->id==$comparo) $combo.= " selected ";
				  $combo.= '>'.$ver.'</option>';
				}
				}
		    $combo.=' </select>';
			return $combo;
	}
	
	//getComboCats($tabindex,"cat_ids[]", explode(',',$res->cat_ids) ,"",'Seleccione multiples familias');
	function getComboCats(&$tabindex,$nombre,$comparo='',$where='',$empty, $extra) {
		
		
		$combo= '<select name="'.$nombre.'" id="'.$nombre.'" class="form-control chosen-select" tabindex="'.$tabindex.'" '.$extra.'>';
		
		if ($empty=='admin'){
			$combo.=  '<option value="'.CAT_MAESTRA.'"';
			if (CAT_MAESTRA==$comparo) $combo.= " selected ";
			$combo.= '>WEB_ID : '.WEB_ID.'</option>';
		}
		
		$combo.= ($empty<>'' && $empty<>'admin')? '<option value="">'.$empty.'</option>' : '';
		
		$cats = $this->cata->select("padre='".CAT_MAESTRA."'",'orden asc, cata_es asc');
		if ($cats and $cats->num_rows()>0){	
			while ($cats->fetch($cat)) {
				if($where=='')
					$sCats = $this->cata->select("padre='".$cat->id."'",'orden asc, cata_es asc');
				
				$combo.= '<option value="'.$cat->id.'"';
					
					if (is_array($comparo)){
						if (in_array($cat->id,$comparo)) $combo.= " selected ";
					}else{
						if ($cat->id==$comparo) $combo.= " selected ";
					}
					
					
					
					$combo.= '>'.$cat->cata_es.'</option>';
					
				if ($sCats and $sCats->num_rows()>=0){	
					
					while ($sCats->fetch($scat)) {
						$combo.= '<option value="'.$scat->id.'"';
						
						if (is_array($comparo)){
							if (in_array($scat->id,$comparo)) $combo.= " selected ";
						}else{
							if ($scat->id==$comparo) $combo.= " selected ";
						}

						
						
						$combo.= '>&nbsp;-'.$scat->cata_es.'</option>';
					}
				}
			}
		}
		
		$combo.=' </select>';
		$tabindex++;
		return $combo;		
	}	
	
	function getComboAny(&$tabindex,$nombre, $table,$comparo='',$where='',$orden='' ,$valor='id',$css='',$muestra='',$empty) {
			$combo= '<select name="'.$nombre.'" id="'.$nombre.'" '.$css.' tabindex="'.$tabindex.'">';
   			$cat=$this->$table->select("".$where,$orden);			
			$combo.= ($empty<>'')? '<option value="">'.$empty.'</option>' : '';
				if ($cat>0){ 
				while ($cat->fetch($cat)){
					
				/*lo que muestra, se ve.*/	
				if (is_array($muestra)){
					$toVer = ''; $i=0;
					foreach ($muestra as $muest ){
						if ($i>0) $toVer .=  ' - ';
						$toVer .=  $cat->$muest;
						$i++;
					}
					$ver = $toVer;
				} else {
					$ver = ($muestra<>'')	?	$cat->$muestra  : 	$cat->name;
				}
				
				
				
				  $combo.= '<option value="'.$cat->$valor.'"';
				  if (is_array($comparo)){
				  	if (in_array($cat->$valor,$comparo)) $combo.= " selected ";
				  }else{
				  	if ($cat->$valor==$comparo) $combo.= " selected ";
				  }
				  $combo.= '>';
				  if ($table=='cata' && $cat->padre<>'0') $combo.='&nbsp;&nbsp;..-.. ';
				  if ($table=='tipologia' && $cat->padre<>'0') $combo.=$this->getValue($cat->padre,'cata','cata_es') .' .-. ';
				  $combo.=$ver;
				  $combo.='</option>';
				 
				}
				}
		    $combo.=' </select>';
			$tabindex++;
			return $combo;
	}	
	
	
	
	function getComboDouble($nombre, $table,$comparo='',$where='',$orden='' ,$valor='id',$css='',$muestra='',$identificador) {
			$combo= '<select name="'.$nombre.'" id="'.$identificador.'" '.$css.' tabindex="'.$tabindex.'">';
   			$cat=$this->$table->select("".$where,$orden);			
			$combo.= ($empty<>'')? '<option>'.$empty.'</option>' : '';
				if ($cat>0){ 
				while ($cat->fetch($cat)){
					if($identificador=='box2View' and in_array($cat->id,$comparo)){
						$ver = ($muestra<>'')?$cat->$muestra  :$cat->name;
						$combo.= '<option value="'.$cat->$valor.'">';
						$combo.=$ver;
						$combo.='</option>';
					}elseif($identificador=='box1View'){
						$ver = ($muestra<>'')?$cat->$muestra  :$cat->name;
						$combo.= '<option value="'.$cat->$valor.'">';
						$combo.=$ver;
						$combo.='</option>';
					}
				}
				}
		    $combo.=' </select>';
			$tabindex++;
			return $combo;
	}
	function getComboArrays(&$tabindex,$nombre,$comparo='',$valores, $css='',$emptyValue) {
			$combo= '<select name="'.$nombre.'" id="'.$nombre.'" '.$css.' tabindex="'.$tabindex.'">';
			$combo.= ($emptyValue<>'')? '<option value="">'.$emptyValue.'</option>' : '';
			foreach ($valores as $k => $v) {
				$combo.= '<option value="'.$k.'"';
				if ($k==$comparo) $combo.= " selected ";
				$combo.= '>'.$v.'</option>';
			}
		    $combo.=' </select>';
			$tabindex++;
			return $combo;
	}
	


	/* backup the db OR just a table */
	function backup_tablesN($dir,$tables = '*',$exclude = array()){
	  if($tables == '*')  {
			$tables = array();
			$res = $this->conn->query('SHOW TABLES');
			while($row = $res->fetch_row()){
				if (false == in_array($row[0],$exclude))
					$tables[] = $row[0];
			}
	  }  else  {
			$tables = is_array($tables) ? $tables : explode(',',$tables);
	  }
	  foreach($tables as $table)  {
			$res = $this->conn->query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields(mysql_query('SELECT * FROM '.$table));
			$return.= 'DROP TABLE '.$table.';';
			$createRes2 = $this->conn->query('SHOW CREATE TABLE '.$table);
			$row2 = $createRes2->fetch_row();
			$return.= "\n\n".$row2[1].";\n\n";
			for ($i = 0; $i < $num_fields; $i++) {
				while ($row = $res->fetch_row()){
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 	{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = str_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
				}
			}
			$return.="\n\n\n";
	  }
	  //save file
	  $handle = fopen($dir.'db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	  fwrite($handle,$return);
	  fclose($handle);
	}
	

	
	function optimize_database(){
		$allTables = $this->conn->query('SHOW TABLE STATUS');
		while ($allTables->fetch($allTables)){
			$res = $this->conn->query("OPTIMIZE TABLE ".$allTables->Name);
			if ($res != false) {
				$res->fetch($res);
				$Subresult = $res->res;
				$class=($class=='even')?'odd':'even';
				$resStr .= "<tr class=\"".$class."\">
				<td>".$res->Table."<br /></td>
				<td>".$res->Msg_type." : ".$res->Msg_text."</td>
				<td style=\"text-align:right;\">".$this->format_size($allTables->Data_length)."</td>
				<td style=\"text-align:right;\">".$this->format_size($allTables->Data_free)."</td>
				</tr>";
			}
		}
		return $resStr ;
	}
	
	function format_size($size) {
			$measure = "Byte";
			if ($size >= 1024) {
				$size = $size / 1024;
				$measure = "kiB";
			}
			if ($size >= 1024) {
				$size = $size / 1024;
				$measure = "MiB";
			}
		$return = sprintf('%0.4s',$size);
		if (substr($return, -1) == "." ) $return = substr($return, 0, -1);
		return $return . " ". $measure;
	}
	
}