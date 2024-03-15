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


    <?php if(isset($alreadyerror) && $alreadyerror!=""){ ?>
       
    <section class="content alertcontent">    
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Errors!</h4>
                <?php echo $alreadyerror; ?>
            </div>
        </section>
    <?php }?>




    <?php if($this->session->flashdata('phoneerror') && $this->session->flashdata('phoneerror')!=""){ ?>
     <section class="content alertcontent">    
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Errors!</h4>
                <?php echo $this->session->flashdata('phoneerror'); ?>
            </div>
        </section>
    <?php }?>


    <?php if(isset($alreadyerror) && $alreadyerror!=""){ ?>




    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th class="desktoptab">Name</th>
                <!-- <th class="desktoptab">Email</th>-->
                <th class="desktoptab">Phone</th>
                <!--<th class="desktoptab">CNIC</th>
                <th class="desktoptab">Address</th>-->
                <th class="desktoptab">Fees</th>
                <th class="desktoptab">Fees Date</th>

                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php //echo "<pre>"; var_dump($gyms); exit; //echo "<pre>"; var_dump($patients); exit;
            foreach ($validateduser as $member):  ?>
                <tr>
                    <td><?php echo $member['name']; ?></td>
                    <!--<td><?php echo $member['email']; ?></td>-->
                    <td><?php echo $member['phone']; ?></td>
                    <!--<td><?php echo $member['cnic']; ?></td>
                            <td><?php echo $member['address']; ?></td>-->
                    <?php if(isset($member['packagedetail']) && !empty($member['packagedetail'])){?>
                        <td>Rs<?php echo $member['packagedetail']['fees']; ?></td>
                    <?php } else{ ?>
                        <td>Rs<?php echo $member['fees']; ?></td>
                    <?php } ?>

                    <td><?php echo date("d-M-y",$member['fee_date']); ?></td>
                    <td>
                        <a href="<?=site_url('admin/members/view/'.$member['id'].'')?>" >Detail</a>
                    </td>






                    <div class="modal fade" id="myModal_<?php echo $member['id']; ?>" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title color-black">Delete Patient</h4>
                                </div>
                                <div class="modal-body color-black">
                                    <p>Are you sure you want to delete.</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="<?php echo site_url('admin/members/delete/'.$member['id'])?>" type="button" class="btn btn-default color-black">Yes</a>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                            <!-- END Modal content-->

                        </div>
                    </div>



            <?php endforeach; ?>

            </tbody>

        </table>
    </div><!-- /.box-body -->



    <?php } ?>

<section class="content-header">
      <h1>
        Add Member
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/members">Members</a></li>
        <li class="active">Add Member</li>
      </ol>
    </section>
     <section class="content">
              <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Add Member</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="<?=site_url('admin/members/add')?>" method="post" enctype="multipart/form-data">
                 <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Name</label>
                        <input type="text" class="form-control capitalizeinput"  value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>"  id="name" name="name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Email</label>
                        <input type="email"  class="form-control" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>"  id="email" name="email" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Phone</label>
                        <input maxlength="12" type="text"  class="form-control" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];} ?>"  id="phone" name="phone" placeholder="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Package Type</label>
                        <select class="packgchanger form-control select2" name="package">
                            <option value="">Select Package</option>
                            <?php foreach ($packages as $package) { ?>
                                <option value="<?php echo $package['id']; ?>"><?php echo $package['name']; ?></option>
                            <?php } ?>
                            <option value="custom">Custom package</option>
                        </select>
                    </div>
                </div>


                <div class="custompckg">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Admission Fees</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['admission_fees'])){echo $_POST['admission_fees'];} ?>"  id="admission_fees" name="admission_fees" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Fees</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['fees'])){echo $_POST['fees'];} ?>"  id="fees" name="fees" placeholder="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group custompaymcr">
                        <label for="f_name">Payment Criteria</label>
                        <span class="lblradio">Monthly</span>
                        <input type="radio"  value="1"  id="payment_radio" name="payment_radio" placeholder="" class="">
                        <span class="btwor">OR</span>
                        <select class="twoselect select2 innerdurationselect" name="payment_select">
                            <option value="">Select Duration</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                </div>
                </div>
                 
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Joining Date</label>
                        <input type="text" class="form-control joining_date" value="<?php if(isset($_POST['joining_date'])){echo $_POST['joining_date'];}else{ echo date('m/d/Y'); } ?>" name="joining_date" id="datepicker">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Fee Date</label>
                        <input type="text" class="form-control datepicker fee_date" value="<?php if(isset($_POST['fee_date'])){echo $_POST['fee_date'];}else{ echo date('m/d/Y',strtotime("+1 month", strtotime(date('m/d/Y')))); } ?>" name="fee_date" id="">
                    </div>
                </div>
                 
                <a class="slideadvancedoptions">Advance Options <span><i class="fa fa-arrow-down" aria-hidden="true"></i></span></a>
                <div class="advancememberoptions">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cnic">CNIC</label>
                        <input  maxlength="13" type="text"  class="form-control" value="<?php if(isset($_POST['cnic'])){echo $_POST['cnic'];} ?>"  id="cnic" name="cnic" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Address</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['address'])){echo $_POST['address'];} ?>"  id="address" name="address" placeholder="">
                    </div>
                </div>
               
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Body Weight(KG)</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['body_weight'])){echo $_POST['body_weight'];} ?>"  id="body_weight" name="body_weight" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Height (Feet)</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['height'])){echo $_POST['height'];} ?>"  id="height" name="height" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Secondary Name</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['secondary_name'])){echo $_POST['secondary_name'];} ?>"  id="secondary_name" name="secondary_name" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Secondary Phone</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['secondary_phone'])){echo $_POST['secondary_phone'];} ?>"  id="secondary_phone" name="secondary_phone" placeholder="">
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group fullselect">
                        <label for="f_name">Blood Group</label>

                        <select class="form-control select2" name="blood_group">
                            <option value="">Select Blood Group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                </div>
                     <div class="col-md-6">
                    <div class="form-group fullselect">
                        <label for="f_name">Trainers</label>
                        <select class="form-control select2 trainerchanger" name="trainer_id">
                            <option value="0">Select Trainer</option>
                            <?php foreach ($trainers as $trainer) { ?>
                                <option data-trainingfees="<?php echo $trainer['training_fees']; ?>"  data-commissionpercentage="<?php echo $trainer['commission_percentage']; ?>" value="<?php echo $trainer['id']; ?>"><?php echo $trainer['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="trainer_details">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cnic">Training Fees</label>
                        <input type="number"  class="form-control" value="<?php if(isset($_POST['training_fees'])){echo $_POST['training_fees'];} ?>"  id="training_fees" name="training_fees" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cnic">Commission(%)</label>
                        <input type="number" min="0" max="100" class="form-control" value="<?php if(isset($_POST['commission_percentage'])){echo $_POST['commission_percentage'];} ?>"  id="commission_percentage" name="commission_percentage" placeholder="">
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
                        <input  maxlength="13" type="text"  class="form-control" value="<?php if(isset($_POST['refrence_no'])){echo $_POST['refrence_no'];} ?>"  id="refrence_no" name="refrence_no" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group genderform genderardoptionform">
                        <label for="f_name">Gender</label>
                        <span>Male</span><input type="radio" checked value="Male" name="gender" class="flat-red">
                        
                        <span>Female</span><input type="radio"  value="Female" name="gender" class="flat-red">
                    </div>
                
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="f_name">Active</label>
                        <input type="checkbox" class="flat-red" checked value="1"  id="status" name="status" placeholder="">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="f_name">Comment</label>
                        <textarea class="form-control" name="comment" placeholder=""><?php if(isset($_POST['comment'])){echo $_POST['comment'];} ?></textarea>
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
            <!-- /.box-body -->
          </div>
        </section>
    
</div>
    
    
    
<script>
    var randomid = Math.floor(Math.random() * (999 - 000 + 1)) + 000;
    document.getElementById("id").value = 'Customer # '+randomid;
    document.getElementById("customer_id").value = randomid;

</script>

