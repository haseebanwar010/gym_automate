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
        Add City
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>superadmin/cities">Cities</a></li>
        <li class="active">Add City</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-warning">
    <div class="box-header with-border">
                <h3 class="box-title">New City</h3>
                
            </div>
        <div class="box-body">
           
            
            <form role="form" action="<?=site_url('superadmin/cities/add')?>" method="post" enctype="multipart/form-data">
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
                    	<label for="f_name">City Name</label>
                        <input type="text" class="form-control"  value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>"  id="name" name="name" placeholder="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Country</label>
                        <select name="country" class="form-control select2">
                            <option value="">Please select country</option>

                            <?php foreach ($countries as $country){ ?>
                            <option <?php if(isset($_POST['country']) && $_POST['country']==$country['id']){echo "selected";} ?> value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                            <?php } ?>

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
</div>