<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
 

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
              <h3 class="box-title custombox_titleset">Body Composition/Measurement And Fitness Tests Of The Member</h3>
              <a href="<?php echo $baseUrl;?>admin/members/addbodycomposition/<?php echo $members['id'];?>"><button type="button" class="btn bg-navy margin addbtn">Add New</button></a>
            </div>
<?php if(isset($members) && $members!='undefined') {?>
           	   <div class="col-md-3 bodycomposition">
            	   <div class="form-group">
                    	<label for="f_name">Reference No</label>
                        <input type="text" class="form-control" required="required" value="<?php echo $members['refrence_no']; ?>" id="name" name="name" placeholder="" disabled>
                    </div>
              </div>

           	   <div class="col-md-3 bodycomposition">
            	   <div class="form-group">
                    	<label for="f_name">Name</label>
                        <input type="text" class="form-control" required="required" id="name" name="name" placeholder="" value="<?php echo $members['name']; ?>" disabled>
                    </div>
              </div>

           	   <div class="col-md-3 bodycomposition">
            	   <div class="form-group">
                    	<label for="f_name">Gender</label>
                        <input type="text" class="form-control" required="required" id="name" name="name" placeholder="" value="<?php echo $members['gender']; ?>" disabled>
                    </div>
              </div>

           	   <div class="col-md-3 bodycomposition">
            	   <div class="form-group">
                    	<label for="f_name">Phone No</label>
                        <input type="text" class="form-control" required="required" id="name" name="name" placeholder="" value="<?php echo $members['phone']; ?>" disabled>
                    </div>
              </div>

            	
          
            
            <!-- /.box-header -->
            <div class="box-body setcustompagesup">
<!--             <h3 class="customsettingsofbody">Physical Activity Readiness (with the help of PAR-Q Card)</h3>-->
             
             
             <?php if(isset($membersbody) && $membersbody!=''){?>
               
                <table id="body_composition_data" class="table table-bordered">
                    
 
                    <thead>
                        <tr>
                            <th class="setratiomeasure" rowspan="2" style="min-width: 75px;">Test Dates</th>
                            <th class="setratiomeasure" colspan="23">Test Ratios/Measurements</th>
                            
                        </tr>
                        <tr>
                            
                            <th style="min-width: 70px;">Body Fat %</th>
                            <th style="min-width: 87px;">Body Water %</th>
                            <th style="min-width: 112px;">Lean Body Mass %</th>
                            <th style="min-width: 35px;">BMI</th>
                            <th style="min-width: 168px;">Basal Metabolic Rate (Kcal)</th>
                            <th style="min-width: 84px;">Bone Density</th>
                            <th style="min-width: 45px;">Height</th>
                            <th style="min-width: 45px;">Weight</th>
                            <th style="min-width: 45px;">Neck</th>
                            <th style="min-width: 45px;">Chest</th>
                            <th style="min-width: 45px;">Abs</th>
                            <th style="min-width: 45px;">Waist</th>
                            <th style="min-width: 85px;">Arms/Bi-Ceps</th>
                            <th style="min-width: 45px;">Hips</th>
                            <th style="min-width: 45px;">Thighs</th>
                            <th style="min-width: 45px;">Calf </th>
                            <th style="min-width: 100px;">Partial Curl Ups</th>
                            <th style="min-width: 70px;">Flexibility</th>
                            <th style="min-width: 65px;">Push-Ups</th>
                            <th style="min-width: 103px;">Weight Prospect</th>
                            <th style="min-width: 113px;">Member Category</th>
                            <th style="min-width: 180px;">Interviewed and Assessed By</th>
                            <th style="min-width: 176px;">Trainer’s Recommendations</th>
                        </tr>
                        
                    </thead>
                    
                    <tbody>
                        <?php //echo "<pre>"; var_dump($members); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($membersbody as $body):
                           ?>

                                <tr>
                                   
                                    <td class=""><b><?php echo $body['posted_date']; ?></b></td>
                                    <td class=""><?php echo $body['body_fat']; ?></td>
                                    <td class=""><?php echo $body['body_water']; ?></td>
                                    <td class=""><?php echo $body['lean_body_mass']; ?></td>
                                    <td class=""><?php echo $body['bmi']; ?></td>
                                    <td class=""><?php echo $body['basal_metabolic_rate']; ?></td>
                                    <td class=""><?php echo $body['bone_density']; ?></td>
                                    <td class=""><?php echo $body['height']; ?></td>
                                    <td class=""><?php echo $body['weight']; ?></td>
                                    <td class=""><?php echo $body['neck']; ?></td>
                                    <td class=""><?php echo $body['chest']; ?></td>
                                    <td class=""><?php echo $body['abs']; ?></td>
                                    <td class=""><?php echo $body['waist']; ?></td>
                                    <td class=""><?php echo $body['arms']; ?></td>
                                    <td class=""><?php echo $body['hips']; ?></td>
                                    <td class=""><?php echo $body['thighs']; ?></td>
                                    <td class=""><?php echo $body['calf']; ?></td>
                                    <td class=""><?php echo $body['partial_curl_ups']; ?></td>
                                    <td class=""><?php echo $body['flexibility']; ?></td>
                                    <td class=""><?php echo $body['pushups']; ?></td>
                                    <td class=""><?php echo $body['weight_prospect']; ?></td>
                                    <td class=""><?php echo $body['member_category']; ?></td>
                                    <td class=""><?php echo $body['assessed_by']; ?></td>
                                    <td class=""><?php echo $body['trainer_recommendation']; ?></td>
                                </tr>
                               
                             
                        <?php endforeach; ?>                                                                                                   

                    </tbody>
                    

                </table>
             <?php }?>
            </div>
            <!-- /.box-body -->
   <?php }?>         
            
            
          </div>
        </section>
    
</div>
    
    


