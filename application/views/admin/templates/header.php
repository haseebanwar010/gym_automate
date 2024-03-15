<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
<script>
    var customfiles=Array();
</script>   
  <title>Gymautomate | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
    <link href="<?php echo $baseUrl; ?>assets/loader/loading.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    
    <!--Export extension css links start-->
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    
    <!--Export extension css links end-->
    
     <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/dist/css/AdminLTE.min.css">
    
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
    
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
   <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/plugins/iCheck/all.css">
    <!-- fullCalendar -->
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/dist/css/custom.css">
    

        <script src="<?php echo $baseUrl; ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $baseUrl; ?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
    
 
    

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    
    
    
    <!--New charts code start-->
    
    <script src="<?php echo $baseUrl; ?>assets/dist/js/Chart.bundle.js"></script>
	<script src="<?php echo $baseUrl; ?>assets/dist/js/utils.js"></script>
    
    <!--New charts code end-->
    <script src="<?php echo $baseUrl; ?>assets/loader/loading.js"></script>
    

</head>
<body id="loading-custom-overlay" class="hold-transition skin-blue-light sidebar-mini">
    <script>
    $('body').loading({
            stoppable: false,
            message: 'Fetching Data, Please Wait...',
            theme: 'dark'
          });
//    setTimeout(function(){
//        $('body').loading('stop');
//    }, 5000);
</script>
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $baseUrl; ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>G</b>AT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b> Gymautomate</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php if($_SESSION['image']!=''){ ?>
              <img src="<?php echo $baseUrl; ?>uploads/<?php echo $_SESSION['image']; ?>" class="user-image" alt="User Image">
                <?php }else{ ?>
                <img src="<?php echo $baseUrl; ?>assets/dist/img/avatar.jpg" class="user-image" alt="User Image">
                <?php } ?>
              <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                  <?php if($_SESSION['image']!=''){ ?>
                <img src="<?php echo $baseUrl; ?>uploads/<?php echo $_SESSION['image']; ?>" class="img-circle" alt="User Image">
<?php }else{ ?>
                <img src="<?php echo $baseUrl; ?>assets/dist/img/avatar.jpg" class="user-image" alt="User Image">
                <?php } ?>
                <p>
                  <?php echo $_SESSION['username']; ?>
                  <small><?php echo $_SESSION['email']; ?></small>
                  <small><?php echo $_SESSION['phone']; ?></small>
                </p>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <!--<div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>-->
                <div class="pull-right">
                  <a href="<?php echo site_url('auth/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
<!--
            <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
-->
          
        </ul>
      </div>
    </nav>
  </header>











