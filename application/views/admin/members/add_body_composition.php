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

     <?php if(!empty($this->session->flashdata('succ_msg'))){ ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $this->session->flashdata('succ_msg')?>
              </div>             
    <?php } ?>
   
   
    <?php if($this->session->flashdata('error_msg') && $this->session->flashdata('error_msg')!=""){ ?>
       
    <section class="content alertcontent">    
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Errors!</h4>
                <?php echo $this->session->flashdata('error_msg'); ?>
            </div>
        </section>
    <?php }?>




<section class="content-header">
      <h1>
        Body Composition & Fitness
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/members">Members</a></li>
        <li class="active">Body Composition & Fitness</li>
      </ol>
</section>
     <section class="content">
              <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title customsetupbox_title">Physical Activity Readiness (with the help of PAR-Q Card)</h3>
            </div>

            	
          
            
            <!-- /.box-header -->
            <div class="box-body">
              
              <form role="form" action="<?=site_url('admin/members/addbodycomposition')?>" method="post" enctype="multipart/form-data">
              
              <div class="managebody_composition">
              
              <div class="col-sm-3">
                    <div class="form-group">
                    	<label for="">Date</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="posted_date" id="datepicker">
                    </div>
              </div>
                            
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Body Fat %</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="body_fat" placeholder="">
                    </div>
              </div>
                            
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Body Water%</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="body_water" placeholder="">
                    </div>
              </div>
                            
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Lean Body Mass%</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="lean_body_mass" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">BMI</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="bmi" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Basal Metabolic Rate (Kcal)</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="basal_metabolic_rate" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Bone Density</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="bone_density" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Height(0.0)</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="height" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Weight(kg)</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="weight" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Neck</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="neck" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Chest</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="chest" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Abs</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="abs" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Waist</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="waist" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Arms/Bi-Ceps</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="arms" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Hips</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="hips" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Thighs</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="thighs" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Calf</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="calf" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Partial Curl ups</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="partial_curl_ups" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Flexibility</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="flexibility" placeholder="">
                    </div>
              </div>
                                          
              <div class="col-sm-3 ">
                    <div class="form-group">
                    	<label for="">Push-ups</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="pushups" placeholder="">
                    </div>
              </div>
                                                         
              <div class="col-sm-3 ">
                    <div class="form-group genderform genderardoptionform">
                        <label for="">Weight Prospect</label>
                        <span>Gain</span><input type="radio"  value="Gain" name="weight_prospect" class="flat-red">
                        
                        <span>Lose</span><input type="radio"  value="Lose" name="weight_prospect" class="flat-red">
                    </div>
              </div>
                                                                        
              <div class="col-sm-3 ">
                    <div class="form-group genderform genderardoptionform">
                        <label for="">Member Category</label>
                        <span>Personal</span><input type="radio"  value="Personal" name="member_category" class="flat-red">
                        
                        <span>General</span><input type="radio" checked value="General" name="member_category" class="flat-red">
                    </div>
              </div>
                                                        
              <div class="col-sm-6 ">
                    <div class="form-group">
                    	<label for="">Interviewed and Assessed By</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="assessed_by" placeholder="">
                    </div>
              </div>
                                                          
              <div class="col-sm-12 ">
                    <div class="form-group">
                    	<label for="">Trainer’s Recommendations</label>
                        <input type="text" class="form-control capitalizeinput" value="" name="trainer_recommendation" placeholder="">
                    </div>
              </div>
                   
              <div class="col-sm-12 pull-right">
              <input type="hidden" name="member_id" value="<?php echo $memberid;?>">
              <input type="submit" class="btn bg-navy margin addbtn" value="Submit">
              </div>
                                                                                            
              </div>

              </form>
            </div>
            <!-- /.box-body -->
          </div>
        </section>
    
</div>
    
    


