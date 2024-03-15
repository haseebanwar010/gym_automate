<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?> 
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    
         <section class="content-header">
      <h1>
        Site Settings
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>settings">Site Settings</a></li>
        <li class="active">Update Settings</li>
      </ol>
    </section>
        <!-- Main content -->
        <section class="content">
                
     <?php
          
          if(!empty($this->session->flashdata('msg'))){
    
    ?>
    <section class="msg">
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?=$this->session->flashdata('msg')?>
        </div>   
    </section>                 
    <?php } ?>

      
            <div class="box box-warning">
        <div class="box-header customer">
                <h3 class="box-title">Update Settings</h3>
                
            </div>
          <div class="box-body">
            <form class="sometopmargin" role="form" action="<?=site_url('admin/settings/update/')?>" method="post" enctype="multipart/form-data">
            
            
                
                
                
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Fees Date Limit (days)</label>
                        <input type="number" class="form-control" required="required" value="<?php echo $settings_data[0]['fees_limit'] ?>"  id="fees_limit" name="fees_limit" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Upcoming Fees Date Limit (days)</label>
                        <input type="number" required class="form-control" value="<?php echo $settings_data[0]['sms_limit'] ?>"  id="sms_limit" name="sms_limit" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group genderform genderardoptionform">
                        <label for="f_name">Printer Option</label>
                        <span>A4 Printer</span><input type="radio" <?php if($settings_data[0]['printer_option']==1){ echo "checked"; } ?>  value="1" name="printer_option" class="flat-red">
                        
                        <span>80mm thermal printer</span><input type="radio" <?php if($settings_data[0]['printer_option']==2){ echo "checked"; } ?> value="2" name="printer_option" class="flat-red">
                    </div>
                
                </div>
            
<!--
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">TimeZone</label>
                        <input type="text" required class="form-control" value="<?php echo $settings_data[0]['timezone'] ?>"  id="sms_limit" name="timezone" placeholder="">
                    </div>
                </div>
-->
                <div class="col-md-6">
                    <div class="form-group checkboxsett">
                        <label for="f_name">Show Fees (In Listing Pages)</label>
                        <input <?php if($settings_data[0]['show_fees']==1){ echo "checked"; } ?> type="checkbox" value="1"  id="" name="show_fees" class="flat-red">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group checkboxsett">
                        <label for="f_name">Show Phone# (In Listing Pages)</label>
                        <input <?php if($settings_data[0]['show_phone']==1){ echo "checked"; } ?> type="checkbox" value="1"  id="" name="show_phone" class="flat-red">
                    </div>
                </div>
                <div class="col-md-6 clearall">
                    <div class="form-group">
                        <label for="f_name">Remaining SMS Bucket: <b><?php echo $settings_data[0]['sms_counter_limit']; ?></b></label>
                        
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
       