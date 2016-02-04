<?php

require_once("lib/base.inc.php");
$s = new Session();
//$s->assertSubAdmin();

$title = 'Private Area';

include('parts/header.php');

echo 'Welcome <b>'.$s->user->name.'</b> to the Sunnyface.com PHP ADO';

printR($s);
printAll();

include('parts/footer.php');