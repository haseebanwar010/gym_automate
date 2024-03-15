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
        Add Package
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/packages">Packages</a></li>
        <li class="active">Add Package</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-warning">
    <div class="box-header with-border">
                <h3 class="box-title">New Package</h3>
                
            </div>
        <div class="box-body">
            <form role="form" action="<?=site_url('admin/packages/add')?>" method="post" enctype="multipart/form-data">
             

                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Package Name</label>
                        <input type="text" class="form-control"  value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>"  id="name" name="name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Admission Fees</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['admission_fees'])){echo $_POST['admission_fees'];} ?>"  id="admission_fees" name="admission_fees" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Fees</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['fees'])){echo $_POST['fees'];} ?>"  id="fees" name="fees" placeholder="">
                    </div>
                </div>
                <input type="hidden"  class="form-control" value="1"  id="members" name="members" placeholder="">
<!--
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Members</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['members'])){echo $_POST['members'];} ?>"  id="members" name="members" placeholder="">
                    </div>
                </div>
-->

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Duration</label>
                        <select class="form-control select2" name="duration">
                            <option value="">Select Duration</option>
                            <option value="1">1</option>
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