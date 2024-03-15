<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
<?php if(validation_errors()){ ?>
   <section class="content alertcontent">    
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <?php echo validation_errors(); ?>
            </div>
        </section>

    <?php } ?>
    <section class="content-header">
      <h1>
        Add User
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>users">Users</a></li>
        <li class="active">Add User</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-warning">
    <div class="box-header customer">
                <h3 class="box-title">Add User</h3>
                
            </div>
        <div class="box-body">
            <form role="form" action="<?=site_url('admin/users/addadminusers')?>" method="post" enctype="multipart/form-data">
                <!-- right column -->
                <!--<div class="col-md-12">
                    <div class="form-group">
                    	<label for="id">Customer ID</label>
                        <?php $customer_id = rand(100, 999); ?>
                        <input type="text" class="form-control" disabled id="id"  name="id" value="Customer # <?=$customer_id?>">
                        <input type="hidden" name="customer_id" id="customer_id" value="<?=$customer_id?>" />
                    </div>
                </div>   -->         
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Name</label>
                        <input type="text" class="form-control" value="<?php if(isset($_POST['name'])){echo $_POST['name'];}?>"  id="name" name="name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Email</label>
                        <input type="email" class="form-control" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>"  id="email" name="email" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Phone</label>
                        <input type="text" class="form-control" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];}?>"  id="phone" name="phone" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">User Name</label>
                        <input type="text" class="form-control" value="<?php if(isset($_POST['user_name'])){echo $_POST['user_name'];}?>"  id="user_name" name="user_name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Password</label>
                        <input type="password" class="form-control" value="<?php if(isset($_POST['password'])){echo $_POST['password'];}?>"  id="password" name="password" placeholder="">
                    </div>
                </div>
           
<div class="col-md-12">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Dashboard</label>
                        <input class="flat-red" type="checkbox" value="1" class="" name="dashboard_access" placeholder="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Members</label>
                        <input class="flat-red" type="checkbox" value="1" class="" name="members_access" placeholder="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Packages</label>
                        <input class="flat-red" type="checkbox"  value="1" class="" name="packages_access" placeholder="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Users</label>
                        <input class="flat-red" type="checkbox" value="1" class="" name="users_access" placeholder="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Staff Members</label>
                        <input class="flat-red" type="checkbox" value="1" class="" name="staffmembers_access" placeholder="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Expenses</label>
                        <input type="checkbox" value="1" name="expenses_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Profit & Loss</label>
                        <input type="checkbox"  value="1" name="profitloss_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Attendences</label>
                        <input type="checkbox" value="1" name="attendences_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Logs</label>
                        <input type="checkbox" value="1" name="logs_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Charts</label>
                        <input type="checkbox" value="1" name="charts_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Calendar</label>
                        <input type="checkbox" value="1" name="calendar_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">SMS</label>
                        <input type="checkbox" value="1" name="sms_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Settings</label>
                        <input type="checkbox" value="1" name="settings_access" class="flat-red">
                    </div>
                </div>
                </div>

<div class="col-lg-12">
                    <div class="form-group">
                        <button class="btn bg-navy margin submitbtn" type="submit">Submit</button>
                    </div>
                </div>

            </form>
        </div>  
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
    var randomid = Math.floor(Math.random() * (999 - 000 + 1)) + 000;
    document.getElementById("id").value = 'Customer # '+randomid;
    document.getElementById("customer_id").value = randomid;

</script>