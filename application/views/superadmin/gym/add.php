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

    <?php if($this->session->flashdata('error') && $this->session->flashdata('error')!=""){ ?>
       
    <section class="content alertcontent">    
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Errors!</h4>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        </section>
    <?php }?>
<section class="content-header">
      <h1>
        Add Gym
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>superadmin/gyms">Gyms</a></li>
        <li class="active">Add Gym</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-warning">
    <div class="box-header with-border">
                <h3 class="box-title">New Gym</h3>
                
            </div>
        <div class="box-body">
           
            <form role="form" action="<?=site_url('superadmin/gym/add')?>" method="post" enctype="multipart/form-data">
                <!-- right column -->
                <div class="col-md-12"><div class=""></div></div>
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
                    	<label for="f_name">Gym Name</label>
                        <input type="text" class="form-control"  value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>"  id="name" name="name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">User Name <span class="innerspan">(Without Spaces)</span></label>
                        <!--pattern="\S+"-->
                        <input type="text" pattern="\S+" class="form-control"  value="<?php if(isset($_POST['user_name'])){echo $_POST['user_name'];} ?>"  id="user_name" name="user_name" placeholder="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control"  value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>"  id="email" name="email" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Password</label>
                        <input type="password"  class="form-control" value="<?php if(isset($_POST['password'])){echo $_POST['password'];} ?>"  id="password" name="password" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Phone</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];} ?>"  id="phone" name="phone" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Address</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['address'])){echo $_POST['address'];} ?>"  id="address" name="address" placeholder="">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Country</label>
                        <select name="country" id="supercountrychanger" class="form-control select2">
                            <option value="">Please select country</option>

                            <?php foreach ($countries as $country){ ?>
                                <option <?php if(isset($_POST['country']) && $_POST['country']==$country['id']){echo "selected";} ?> value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">City</label>
                        <select name="city" id="supercity" class="form-control select2">
                            <option value="">Please select City</option>
                            <?php foreach ($cities as $city){ ?>
                                <option data-countryid="<?php echo $city['country_id']; ?>" <?php if(isset($_POST['city']) && $_POST['city']==$city['id']){echo "selected";} ?> value="<?php echo $city['id']; ?>"><?php echo $city['name']; ?></option>
                            <?php } ?>


                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Currency</label>
                        <select name="currency" id="" class="form-control select2">
                            <option value="">Please select currency</option>

                            <?php foreach ($currencies as $currency){ ?>
                                <option <?php if(isset($_POST['currency']) && $_POST['currency']==$currency['id']){echo "selected";} ?> value="<?php echo $currency['id']; ?>"><?php echo $currency['currency_name']." (".$currency['currency_symbol'].")"; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>





                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Image</label>
                        <input type="file"  class="form-control imageinput" value=""  id="image" name="image" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">TimeZone</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['timezone'])){echo $_POST['timezone'];} ?>"  id="timezone" name="timezone" placeholder="">
                    </div>
                </div>
               <!-- <div class="col-md-3 parentheight">
                    <div class="form-group">
                    	<label for="f_name">Parent Gym</label>
                        <input checked disabled type="checkbox" value="1"  id="parent_gym" name="parent_gym" placeholder="">
                    </div>
                </div>-->
                
                <!--<div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">City</label>
                        <select name="city">
                            <option value=""></option>
                                <option value="lahore">Lahore</option>

                        </select>
                    </div>
                </div>-->

               

                <div class="col-md-3">
                    <div class="form-group myoptbullets">
                        <label for="f_name">Package Type</label>
                        <span>Basic</span><input type="radio" value="1" checked name="package_type" placeholder="">
                        <span>Basic Plus</span><input type="radio" value="2" name="package_type" placeholder="">
                        <span>Advance</span><input type="radio" value="3" name="package_type" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group myoptbullets">
                        <label for="f_name">Payment Criteria</label>
                        <span>Monthly</span><input type="radio" value="1" checked name="payment_criteria" placeholder="">
                        <span>Half year</span><input type="radio" value="2" name="payment_criteria" placeholder="">
                        <span>yearly</span><input type="radio" value="3" name="payment_criteria" placeholder="">
                    </div>
                </div>
<div class="col-md-3 parentheight">
                    <div class="form-group">
                        <label for="f_name">Add User</label>
                        <input type="checkbox" value="1"  id="add_user_status" name="add_user_status" placeholder="">
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
</div>
