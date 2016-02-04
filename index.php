<?php
require_once("lib/base.inc.php");
$s = new Session(false);
$title = 'Public page';
include('parts/header.php');
?>


<div class="jumbotron">
  <h1 class="display-3">Welcome to <?php echo $s->web->name;?></h1>
  <p class="lead">This is a very simple PHP framework made for fast PHP proccessing and development, ADO + Basic Helper Classes to get you going on a development fast.</p>
  <hr class="m-y-md">
  <p>Use it as you wish, and if you want to colaborate you are very welcome to push your commits to the master source.</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="/admin.php" role="button">Admin area</a>
  </p>
</div>



<?php
include('parts/footer.php');