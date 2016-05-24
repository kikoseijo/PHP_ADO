<?php


function createModel(){
  global $a;
  $sql = "SHOW TABLES FROM " .DbName;
  $res = $a->conn->query($sql);
  if ($res && $res->nr()>0) {
    while ($res->fetch($res)) {
      //printR($res);
        echo "Tabla: {$res->Tables_in_w4ntedwww}<br />" . "\n";
        if(substr($res->Tables_in_w4ntedwww,0,13)=='wp_car_rental'){
          $className = ucfirst($res->Tables_in_w4ntedwww);
          $txt = "<?php\n";
          $txt .= "class $className\n";
          $txt .= "{\n";
          $cols = $a->conn->query("SHOW COLUMNS FROM $res->Tables_in_w4ntedwww");
          if ($cols && $cols->nr()>0) {
            while ($cols->fetch($col)) {
              //printR($col);
              $colName = $col->Field;
              $txt .= 'var $'.$colName.';' ."\n";
            }
            $txt .= "}\n";
            $theFile = "./lib/model/".$className.".class.php";
            if(file_put_contents($theFile,$txt)!=false){
              echo "File created (".basename($theFile).")";
            }else{
              echo "Cannot create file (".basename($theFile).")";
            }
          }
        }
    }
  }
}
