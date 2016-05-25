<!doctype html>
<html>

  <head>
  <meta charset="UTF-8">
  <title><?php echo $title?></title>  
  <!-- bower:css -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.css" />
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap-theme.css" />
  <link rel="stylesheet" href="../bower_components/jquery.gritter/css/jquery.gritter.css" />
  <link rel="stylesheet" href="../bower_components/toastr/toastr.css" />
  <!-- endbower -->
  <link rel="stylesheet" type="text/css" href="/assets/css/css.css">
  </head>

  <body <?php echo isset($bodyClass) ? 'class="'.$bodyClass.'"' : '';?>>
    <div class="container">
      <!-- Content here -->
