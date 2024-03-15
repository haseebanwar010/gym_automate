<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?> 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot Password</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
   <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
    
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/dist/css/AdminLTE.min.css">
      <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/dist/css/custom.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/dist/css/style.css">
  </head>
  <body class="hold-transition login-page customloginbody">
    <div class="login-box">
      <!--<div class="login-logo">
        <a href="<?=site_url()?>"><img src="<?php echo $baseUrl?>assets/images/logo.png" width="300" /></a>
      </div>--><!-- /.login-logo -->
      <?php if(isset($msg)){ ?>
        <section class="msg">
        <div class="alert alert-error">
        <a href="#" class="close close-btn" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $msg?>  
            </div>
        </section>                 
        <?php } ?>
      <div class="login-box-body">
        
        <form action="<?php echo site_url('auth/forgot_password')?>" method="post" enctype="multipart/form-data">
          <div class="form-group has-feedback">
           <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <input type="email" required class="form-control" placeholder="Email" name="email">
           
          </div>
          
          <div class="row">
            
            <div class="col-xs-12">
              <button type="submit" class="btn bg-navy margin adminloginbtn">SUBMIT</button>
            </div><!-- /.col -->
          </div>
        </form>

       


      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $baseUrl?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo $baseUrl?>assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo $baseUrl?>assets/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
