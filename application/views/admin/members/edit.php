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
          
           <?php if($this->session->flashdata('phoneerror') && $this->session->flashdata('phoneerror')!=""){ ?>
     <section class="content alertcontent">    
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Errors!</h4>
                <?php echo $this->session->flashdata('phoneerror'); ?>
            </div>
        </section>
    <?php }?>
        
          <section class="content-header">
      <h1>
        Update Member
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/members">Members</a></li>
        <li class="active">Update Member</li>
      </ol>
    </section>
        <!-- Main content -->
        <section class="content">
         <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Update Member</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <form role="form" action="<?=site_url('admin/members/edit/'.$member[0]['id'].'')?>" method="post" enctype="multipart/form-data">
            <input name="id" type="hidden" value="<?php echo $member[0]['id']; ?>">
            
                
                
                
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Name</label>
                        <input type="text" class="form-control" required="required" value="<?php echo $member[0]['name']; ?>"  id="name" name="name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Email</label>
                        <input type="email" class="form-control" value="<?php echo $member[0]['email']; ?>"  id="email" name="email" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Phone</label>
                        <input  maxlength="12" type="text" class="form-control" value="<?php echo $member[0]['phone']; ?>"  id="phone" name="phone" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Package Type</label>
                        <select class="packgchanger form-control select2" name="package">
                            <option value="">Select Package</option>
                            <?php foreach ($packages as $package) { ?>
                                <option <?php if($member[0]['package']==$package['id']){echo "selected";}?> value="<?php echo $package['id']; ?>"><?php echo $package['name']; ?></option>
                            <?php } ?>
                            <option <?php if($member[0]['package']=="custom"){echo "selected";}?> value="custom">Custom package</option>
                        </select>
                    </div>
                </div>

                <div class="custompckg" <?php if(isset($member[0]['package']) && $member[0]['package']=="custom"){?> style="display:block;" <?php }?>   >
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Admission Fees</label>
                        <input type="text" disabled class="form-control" value="<?php echo $member[0]['admission_fees']; ?>"  id="admission_fees" name="admission_fees" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Fees</label>
                        <input type="text"  class="form-control" value="<?php echo $member[0]['fees']; ?>"  id="fees" name="fees" placeholder="">
                    </div>
                </div>
                    <div class="col-md-6">
                        <div class="form-group custompaymcr">
                            <label for="f_name">Payment Criteria</label>
                            <span class="lblradio">Monthly</span><input type="radio" <?php if($member[0]['payment_criteria']==1){echo "checked";}?> value="1"  id="payment_radio" name="payment_radio" placeholder="" class="flat-red">
                            <span class="btwor">OR</span>
                            <select class="twoselect select2" name="payment_select">
                                <option value="">Select Duration</option>
                                <option <?php if($member[0]['payment_criteria']==2){echo "selected";}?> value="2">2</option>
                                <option <?php if($member[0]['payment_criteria']==3){echo "selected";}?> value="3">3</option>
                                <option <?php if($member[0]['payment_criteria']==4){echo "selected";}?> value="4">4</option>
                                <option <?php if($member[0]['payment_criteria']==5){echo "selected";}?> value="5">5</option>
                                <option <?php if($member[0]['payment_criteria']==6){echo "selected";}?> value="6">6</option>
                                <option <?php if($member[0]['payment_criteria']==7){echo "selected";}?> value="7">7</option>
                                <option <?php if($member[0]['payment_criteria']==8){echo "selected";}?> value="8">8</option>
                                <option <?php if($member[0]['payment_criteria']==9){echo "selected";}?> value="9">9</option>
                                <option <?php if($member[0]['payment_criteria']==10){echo "selected";}?> value="10">10</option>
                                <option <?php if($member[0]['payment_criteria']==11){echo "selected";}?> value="11">11</option>
                                <option <?php if($member[0]['payment_criteria']==12){echo "selected";}?> value="12">12</option>
                            </select>
                        </div>
                    </div>
                    </div>
                <?php
                $time=$member[0]['joining_date'];
                $ctime=date("d-F-Y",$time);
                $feedate=$member[0]['fee_date'];
                $feedate=date('m/d/Y',$feedate);
                ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Joining Date</label>
                        <input disabled type="text" class="form-control" value="<?php echo $ctime; ?>" name="joining_date" id="datepicker">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Fee Date</label>
                        <input type="text" class="form-control datepicker" value="<?php echo $feedate; ?>" name="fee_date" id="">
                    </div>
                </div>
<a class="slideadvancedoptions">Advance Options <span><i class="fa fa-arrow-down" aria-hidden="true"></i></span></a>
<div class="advancememberoptions">
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="cnic">CNIC</label>
                        <input  maxlength="13" type="text" class="form-control" value="<?php echo $member[0]['cnic']; ?>"  id="cnic" name="cnic" placeholder="">
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Address</label>
                        <input type="text" class="form-control" value="<?php echo $member[0]['address']; ?>"  id="address" name="address" placeholder="">
                    </div>
                </div>
    
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Body Weight(KG)</label>
                        <input type="text"  class="form-control" value="<?php echo $member[0]['body_weight']; ?>"  id="body_weight" name="body_weight" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Height (Feet)</label>
                        <input type="text" class="form-control" value="<?php echo $member[0]['height']; ?>"  id="height" name="height" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Secondary Name</label>
                        <input type="text"  class="form-control" value="<?php echo $member[0]['secondary_name']; ?>"  id="secondary_name" name="secondary_name" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Secondary Phone</label>
                        <input type="text"  class="form-control" value="<?php echo $member[0]['secondary_phone']; ?>"  id="secondary_phone" name="secondary_phone" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group fullselect">
                        <label for="f_name">Blood Group</label>

                        <select class="select2" name="blood_group">

                            <option <?php if($member[0]['blood_group']=="A+"){ echo "selected"; }?> value="A+">A+</option>
                            <option <?php if($member[0]['blood_group']=="A-"){ echo "selected"; }?> value="A-">A-</option>
                            <option <?php if($member[0]['blood_group']=="B+"){ echo "selected"; }?> value="B+">B+</option>
                            <option <?php if($member[0]['blood_group']=="B-"){ echo "selected"; }?> value="B-">B-</option>
                            <option <?php if($member[0]['blood_group']=="O+"){ echo "selected"; }?> value="O+">O+</option>
                            <option <?php if($member[0]['blood_group']=="O-"){ echo "selected"; }?> value="O-">O-</option>
                            <option <?php if($member[0]['blood_group']=="AB+"){ echo "selected"; }?> value="AB+">AB+</option>
                            <option <?php if($member[0]['blood_group']=="AB-"){ echo "selected"; }?> value="AB-">AB-</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group fullselect">
                        <label for="f_name">Trainers</label>
                        <select class="form-control select2 trainerchanger" name="trainer_id">
                            <option value="0">Select Trainer</option>
                            <?php foreach ($trainers as $trainer) { ?>
                                <option <?php if($member[0]['trainer_id']==$trainer['id']){ echo "selected"; }?> data-trainingfees="<?php echo $trainer['training_fees']; ?>"  data-commissionpercentage="<?php echo $trainer['commission_percentage']; ?>" value="<?php echo $trainer['id']; ?>"><?php echo $trainer['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="trainer_details" style="<?php if($member[0]['trainer_id']!=0){ echo "display:block;"; } ?>">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cnic">Training Fees</label>
                        <input type="number"  class="form-control" value="<?php echo $member[0]['training_fees']; ?>"  id="training_fees" name="training_fees" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cnic">Commission(%)</label>
                        <input type="number" min="0" max="100" class="form-control" value="<?php echo $member[0]['commission_percentage']; ?>"  id="commission_percentage" name="commission_percentage" placeholder="">
                    </div>
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
                        <label for="cnic">Refrence Number</label>
                        <input  maxlength="13" type="text"  class="form-control" value="<?php echo $member[0]['refrence_no']; ?>"  id="refrence_no" name="refrence_no" placeholder="">
                    </div>
                </div>
<div class="col-md-3">
                    <div class="form-group genderform genderardoptionform">
                        <label for="f_name">Gender</label>
                        <span>Male</span><input type="radio" <?php if(isset($member[0]['gender']) && $member[0]['gender']=='Male'){echo "checked";}?> value="Male" name="gender" class="flat-red">
                        
                        <span>Female</span><input type="radio" <?php if(isset($member[0]['gender']) && $member[0]['gender']=='Female'){echo "checked";}?> value="Female" name="gender" class="flat-red">
                    </div>
                
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Active</label>
                        <input class="flat-red" type="checkbox" <?php if($member[0]['status']==1){echo "checked";}?> value="1"  id="status" name="status" placeholder="">
                    </div>
                </div>
    <div class="col-md-12">
                    <div class="form-group">
                        <label for="f_name">Comment</label>
                        <textarea class="form-control" name="comment" placeholder=""><?php echo $member[0]['comment']; ?></textarea>
                    </div>
                </div>
                </div> 
     
                
                <div class="col-lg-12">
                    <div class="form-group">
                        <button class="btn bg-navy margin submitbtn" type="submit">Submit</button>
                    </div>
                </div>
            
            </form>
          </div>   <!-- /.row -->
            </div>
            
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
       