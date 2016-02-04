<!doctype html>
<html>

  <head>
  <meta charset="UTF-8">
  <title><?php echo $title?></title>
  <link rel="stylesheet" type="text/css" href="/bower_components/bootstrap/dist/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="/bower_components/jquery.gritter/css/jquery.gritter.css">
  <link rel="stylesheet" type="text/css" href="/bower_components/toastr/toastr.min.css">
  <link rel="stylesheet" type="text/css" href="/assets/css/css.css">
  </head>

  <body <?php echo isset($bodyClass) ? 'class="'.$bodyClass.'"' : '';?>>
    <div class="container">
      <!-- Content here -->
