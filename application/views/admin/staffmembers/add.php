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


<section class="content-header">
      <h1>
        Add Staff Member
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/staffmembers">Staff Members</a></li>
        <li class="active">Add Staff Member</li>
      </ol>
    </section>
     <section class="content">
              <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Add Staff Member</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="<?=site_url('admin/staffmembers/add')?>" method="post" enctype="multipart/form-data">
                 <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Name</label>
                        <input type="text" class="form-control capitalizeinput"  value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>"  id="name" name="name" placeholder="">
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
                        <label for="f_name">Address</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['address'])){echo $_POST['address'];} ?>"  id="address" name="address" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cnic">CNIC</label>
                        <input  maxlength="13" type="text"  class="form-control" value="<?php if(isset($_POST['cnic'])){echo $_POST['cnic'];} ?>"  id="cnic" name="cnic" placeholder="">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Secondary Name</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['secondary_name'])){echo $_POST['secondary_name'];} ?>"  id="secondary_name" name="secondary_name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Secondary Phone</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['secondary_phone'])){echo $_POST['secondary_phone'];} ?>"  id="secondary_phone" name="secondary_phone" placeholder="">
                    </div>
                </div>  
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Salary</label>
                        <input type="number"  class="form-control" value="<?php if(isset($_POST['salary'])){echo $_POST['salary'];} ?>"  id="" name="salary" placeholder="">
                    </div>
                </div>  
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Training Fees</label>
                        <input type="number"  class="form-control" value="<?php if(isset($_POST['training_fees'])){echo $_POST['training_fees'];} ?>"  id="" name="training_fees" placeholder="">
                    </div>
                </div>  
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Commission<span class="innerspan">(%)</span></label>
                        <input type="number"  class="form-control" value="<?php if(isset($_POST['commission_percentage'])){echo $_POST['commission_percentage'];} ?>"  id="" name="commission_percentage" placeholder="">
                    </div>
                </div>  
                  
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Image</label>
                        <input type="file"  class="form-control imageinput" value=""  id="image" name="image" placeholder="">
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
                        <label for="f_name">Active</label><br>
                        <input type="checkbox" class="flat-red" checked value="1"  id="status" name="status" placeholder="">
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
        </section>
    
</div>