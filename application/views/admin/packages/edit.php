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
        Update Package
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/packages">Packages</a></li>
        <li class="active">Update Package</li>
      </ol>
    </section>
        <!-- Main content -->
        <section class="content">
            <div class="box box-warning">
        <div class="box-header customer">
                <h3 class="box-title">Update Package</h3>
                
            </div>
          <div class="box-body">
            <form role="form" action="<?=site_url('admin/packages/edit/'.$package[0]['id'].'')?>" method="post" enctype="multipart/form-data">
            <input name="id" type="hidden" value="<?php echo $package[0]['id']; ?>">
            
                
                
                
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Package Name</label>
                        <input type="text" class="form-control" required="required" value="<?php echo $package[0]['name']; ?>"  id="name" name="name" placeholder="">
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Admission Fees</label>
                        <input type="text"  class="form-control" value="<?php echo $package[0]['admission_fees']; ?>"  id="admission_fees" name="admission_fees" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Fees</label>
                        <input type="text"  class="form-control" value="<?php echo $package[0]['fees']; ?>"  id="fees" name="fees" placeholder="">
                    </div>
                </div>
                <input type="hidden"  class="form-control" value="<?php echo $package[0]['members']; ?>"  id="members" name="members" placeholder="">
<!--
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Members</label>
                        <input type="text"  class="form-control" value="<?php echo $package[0]['members']; ?>"  id="members" name="members" placeholder="">
                    </div>
                </div>
-->

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Duration</label>
                        <select class="form-control select2" name="duration">
                            <option value="">Select Duration</option>
                            <option <?php if($package[0]['duration']==1){echo "selected";} ?> value="1">1</option>
                            <option <?php if($package[0]['duration']==2){echo "selected";} ?> value="2">2</option>
                            <option <?php if($package[0]['duration']==3){echo "selected";} ?> value="3">3</option>
                            <option <?php if($package[0]['duration']==4){echo "selected";} ?> value="4">4</option>
                            <option <?php if($package[0]['duration']==5){echo "selected";} ?> value="5">5</option>
                            <option <?php if($package[0]['duration']==6){echo "selected";} ?> value="6">6</option>
                            <option <?php if($package[0]['duration']==7){echo "selected";} ?> value="7">7</option>
                            <option <?php if($package[0]['duration']==8){echo "selected";} ?> value="8">8</option>
                            <option <?php if($package[0]['duration']==9){echo "selected";} ?> value="9">9</option>
                            <option <?php if($package[0]['duration']==10){echo "selected";} ?> value="10">10</option>
                            <option <?php if($package[0]['duration']==11){echo "selected";} ?> value="11">11</option>
                            <option <?php if($package[0]['duration']==12){echo "selected";} ?> value="12">12</option>
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
       