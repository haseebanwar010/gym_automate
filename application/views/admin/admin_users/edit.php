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
        Update User
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>users">All Users</a></li>
        <li class="active">Update User</li>
      </ol>
    </section>
        <!-- Main content -->
        <section class="content">
            <div class="box box-warning">
        <div class="box-header customer">
                <h3 class="box-title">Update User</h3>
                
            </div>
          <div class="box-body">
            <form role="form" action="<?=site_url('admin/users/editadminusers/'.$user[0]['id'].'')?>" method="post" enctype="multipart/form-data">
            <input name="id" type="hidden" value="<?php echo $user[0]['id']; ?>">



                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Name</label>
                        <input type="text" class="form-control" value="<?php echo $user[0]['name']; ?>"  id="name" name="name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Email</label>
                        <input type="email" class="form-control" value="<?php echo $user[0]['email']; ?>"  id="email" name="email" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Phone</label>
                        <input type="text" class="form-control" value="<?php echo $user[0]['phone']; ?>"  id="phone" name="phone" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
                         $test = $user[0]['user_name'];
$temp = explode('_', $test);
unset($temp[count($temp) - 1]);
$usename=implode('_', $temp);
                        ?>
                        
                        <label for="f_name">User Name</label>
                        <input type="text" class="form-control" value="<?php echo $usename; ?>"  id="user_name" name="user_name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Password</label>
                        <input type="password" class="form-control" value=""  id="password" name="password" placeholder="">
                    </div>
                </div>



<div class="col-md-12">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Dashboard</label>
                        <input class="flat-red" type="checkbox" <?php if(isset($user[0]['authorization']['dashboard_access']) && $user[0]['authorization']['dashboard_access']==1){echo "checked";} ?> value="1" class="" name="dashboard_access" placeholder="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Members</label>
                        <input class="flat-red" type="checkbox" <?php if(isset($user[0]['authorization']['members_access']) && $user[0]['authorization']['members_access']==1){echo "checked";} ?> value="1" class="" name="members_access" placeholder="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Packages</label>
                        <input class="flat-red" type="checkbox" <?php if(isset($user[0]['authorization']['packages_access']) && $user[0]['authorization']['packages_access']==1){echo "checked";} ?> value="1" class="" name="packages_access" placeholder="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Users</label>
                        <input class="flat-red" type="checkbox" <?php if(isset($user[0]['authorization']['users_access']) && $user[0]['authorization']['users_access']==1){echo "checked";} ?> value="1" class="" name="users_access" placeholder="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Staff Members</label>
                        <input class="flat-red" type="checkbox" <?php if(isset($user[0]['authorization']['staffmembers_access']) && $user[0]['authorization']['staffmembers_access']==1){echo "checked";} ?> value="1" class="" name="staffmembers_access" placeholder="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Expenses</label>
                        <input type="checkbox" <?php if(isset($user[0]['authorization']['expenses_access']) && $user[0]['authorization']['expenses_access']==1){echo "checked";} ?> value="1" name="expenses_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Profit & Loss</label>
                        <input type="checkbox" <?php if(isset($user[0]['authorization']['profitloss_access']) && $user[0]['authorization']['profitloss_access']==1){echo "checked";} ?> value="1" name="profitloss_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Attendences</label>
                        <input type="checkbox" <?php if(isset($user[0]['authorization']['attendences_access']) && $user[0]['authorization']['attendences_access']==1){echo "checked";} ?> value="1" name="attendences_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Logs</label>
                        <input type="checkbox" <?php if(isset($user[0]['authorization']['logs_access']) && $user[0]['authorization']['logs_access']==1){echo "checked";} ?> value="1" name="logs_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Charts</label>
                        <input type="checkbox" <?php if(isset($user[0]['authorization']['charts_access']) && $user[0]['authorization']['charts_access']==1){echo "checked";} ?> value="1" name="charts_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Calendar</label>
                        <input type="checkbox" <?php if(isset($user[0]['authorization']['calendar_access']) && $user[0]['authorization']['calendar_access']==1){echo "checked";} ?> value="1" name="calendar_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">SMS</label>
                        <input type="checkbox" <?php if(isset($user[0]['authorization']['sms_access']) && $user[0]['authorization']['sms_access']==1){echo "checked";} ?> value="1" name="sms_access" class="flat-red">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group checkboxform">
                        <label for="f_name">Settings</label>
                        <input type="checkbox" <?php if(isset($user[0]['authorization']['settings_access']) && $user[0]['authorization']['settings_access']==1){echo "checked";} ?> value="1" name="settings_access" class="flat-red">
                    </div>
                </div>
                </div>
<!--
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="f_name">Stats</label>
                        <input class="flat-red" type="checkbox" <?php if($user[0]['authorization']['stats_access']==1){echo "checked";} ?> value="1" class="" name="stats_access" placeholder="">
                    </div>
                </div>
-->
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
       