<?php



function fileExist($img_name,$field){
	$fotito = RootPath.FilesDir . $field ."/". $img_name;
	if (file_exists($fotito)) {
		return true;
	} else
		return false;
}


function deleteFieldFoto($object,$field){ // una imagen concreta segun si ID
		$fotito = RootPath.FilesDir . $field ."/". $object->img;
		if ($object->img<>'' && file_exists($fotito)) {
			unlink( $fotito);
			return true;
		} else
			return false;
}

function deleteFile($carpeta,$filename){ // una imagen concreta segun si ID
		$fotito = RootPath.FilesDir . $carpeta ."/". $filename;
		if ($filename<>'' && file_exists($fotito))
			unlink( $fotito);
}

function file_basename($file= null) {
    $basename = basename ($file);
	$basename = explode(".",$basename);
	//print_r($file);    // returnes Array ( [0] => filename [1] => php ) 
    return $basename[0];    
}

function mkdir_recursive($pathname, $mode)
{
    is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname), $mode);
    return is_dir($pathname) || @mkdir($pathname, $mode);
}

function delete_directory($dir) {
		if ($dh = @opendir($dir)) {
				while (($file = readdir ($dh)) != false) {
					 if (($file == ".") || ($file == "..")) continue;
							if (is_dir($dir . '/' . $file))
								 delete_directory($dir . '/' . $file);
							else
								 unlink($dir . '/' . $file);
				}
				@closedir($dh);
				rmdir($dir);
		}
 }








