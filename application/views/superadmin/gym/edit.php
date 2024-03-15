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
        Update Gym
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>superadmin/gyms">Gyms</a></li>
        <li class="active">Update Gym</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-warning">
    <div class="box-header with-border">
                <h3 class="box-title">Update Gym</h3>
                
            </div>
        <div class="box-body">
           
            <form role="form" action="<?=site_url('superadmin/gym/edit/'.$gym[0]['id'].'')?>" method="post" enctype="multipart/form-data">
            <input name="id" type="hidden" value="<?php echo $gym[0]['id']; ?>">
            
                
                
                
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Gym Name</label>
                        <input type="text" class="form-control" value="<?php echo $gym[0]['name']; ?>"  id="name" name="name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">User Name <span class="innerspan">(Without Spaces)</span></label>
                        <input type="text" pattern="\S+" class="form-control" value="<?php echo $gym[0]['user_name']; ?>"  id="user_name" name="user_name" placeholder="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control"  value="<?php echo $gym[0]['email']; ?>"  id="email" name="email" placeholder="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Password</label>
                        <input type="password"  class="form-control" value=""  id="password" name="password" placeholder="">
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Phone</label>
                        <input type="text" class="form-control" value="<?php echo $gym[0]['phone']; ?>"  id="phone" name="phone" placeholder="">
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Address</label>
                        <input type="text" class="form-control" value="<?php echo $gym[0]['address']; ?>"  id="address" name="address" placeholder="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Country</label>
                        <select name="country" id="supercountrychanger" class="form-control select2">
                            <option value="">Please select country</option>

                            <?php foreach ($countries as $country){ ?>
                                <option <?php if($gym[0]['country_id']==$country['id']){echo "selected";} ?> value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
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
                                <option data-countryid="<?php echo $city['country_id']; ?>" <?php if($gym[0]['city_id']==$city['id']){echo "selected";} ?> value="<?php echo $city['id']; ?>"><?php echo $city['name']; ?></option>
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
                                <option <?php if($gym[0]['currency_id']==$currency['id']){echo "selected";} ?> value="<?php echo $currency['id']; ?>"><?php echo $currency['currency_name']." (".$currency['currency_symbol'].")"; ?></option>
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
                        <input type="text"  class="form-control" value="<?php echo $gym[0]['timezone']; ?>"  id="timezone" name="timezone" placeholder="">
                    </div>
                </div>

                <div class="col-md-3 parentheight">
                    <div class="form-group">
                        <label for="f_name">Active</label>
                        <input type="checkbox" value="1" <?php if(isset($gym[0]['status']) && $gym[0]['status']==1){echo "checked";}?>  id="status" name="status" placeholder="">
                    </div>
                </div>
                
                <div class="col-md-3 parentheight">
                    <div class="form-group">
                        <label for="f_name">Add User</label>
                        <input type="checkbox" value="1" <?php if(isset($gym[0]['add_user_status']) && $gym[0]['add_user_status']==1){echo "checked";}?>  id="add_user_status" name="add_user_status" placeholder="">
                    </div>
                </div>




                <div class="col-md-3">
                    <div class="form-group myoptbullets">
                        <label for="f_name">Package Type</label>
                        <span>Basic</span><input type="radio" <?php if(isset($gym[0]['package_type']) && $gym[0]['package_type']==1){echo "checked";} ?> value="1" name="package_type" placeholder="">
                        <span>Basic Plus</span><input type="radio" <?php if(isset($gym[0]['package_type']) && $gym[0]['package_type']==2){echo "checked";} ?> value="2" name="package_type" placeholder="">
                        <span>Advance</span><input type="radio" <?php if(isset($gym[0]['package_type']) && $gym[0]['package_type']==3){echo "checked";} ?> value="3" name="package_type" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group myoptbullets">
                        <label for="f_name">Payment Criteria</label>
                        <span>Monthly</span><input type="radio" <?php if(isset($gym[0]['payment_criteria']) && $gym[0]['payment_criteria']==1){echo "checked";} ?> value="1" name="payment_criteria" placeholder="">
                        <span>Half year</span><input type="radio" <?php if(isset($gym[0]['payment_criteria']) && $gym[0]['payment_criteria']==2){echo "checked";} ?> value="2" name="payment_criteria" placeholder="">
                        <span>yearly</span><input type="radio" <?php if(isset($gym[0]['payment_criteria']) && $gym[0]['payment_criteria']==3){echo "checked";} ?> value="3" name="payment_criteria" placeholder="">
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




