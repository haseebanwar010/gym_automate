<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
$sizeofinner;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php 
    
    ?>
    
         
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
       
    <!-- Main content -->
      <section class="content-header">
      <h1>
        All Attendence
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>attendences">All Attendence</a></li>
        <li class="active">All Attendence</li>
      </ol>
    </section>
    <section class="content">
<div class="box box-warning">
            <div class="box-header customer">
                <h3 class="box-title">Attendence</h3>
                 
<div class="attendencefilters col-sm-12">
<div class="col-sm-3"></div>
<form method="post" action="<?php echo $baseUrl;?>admin/attendences/attendencelist">
<div class="col-sm-4" id="custom_month_picker">                     
      <input type="text" name="enddate" value="<?php if(isset($_POST['enddate']) && !empty($_POST['enddate'])){echo date('F Y',strtotime($_POST['enddate']));} else{echo date("F Y");} ?>" class="custommonthpicker form-control" placeholder="Select Month" required>

</div>
<div class="col-sm-2">
       <button class="btn bg-navy margin submitbtn submitbtnup" type="submit">Submit</button> 
</div>
</form>
<div class="col-sm-3"></div>                      
</div>                 
                
            </div><!-- /.box-header -->
          
  
         
            <div class="box-body setcustompages">
               <?php if(isset($members) && $members!='undefined'){ ?>
               
                <table id="memberattendencelistchart" class="table table-bordered">
                    <input type="hidden" name="memattchart" id="memberattendencechart" value="<?php echo $daysrange; ?>">
 
                    <thead>
                        <tr>
                            <th class="desktoptab">ID</th>                           
                            <th class="desktoptab"></th>
                            <th class="desktoptab" style="min-width: 100px;">Name</th>                           
                            <th class="desktoptab" style="min-width: 100px;">Trainer Name</th>
                            <th class="desktoptab">Fees</th>
                            <th class="desktoptab" style="min-width: 61px;">Fees Date</th>
                            <?php if($daysrange!=''){?>
                            <?php for($i=1; $i<=$daysrange; $i++){?>
                            <th class="desktoptabupgarde"><?php echo $i; ?></th>
                            <?php }?>
                            <?php }?>
                            <th class="desktoptab">Comments</th>
                            
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php //echo "<pre>"; var_dump($members); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($members as $member):
                           ?>

                                <tr>
                                    <td class="idset"><?php echo $member['id']; ?></td>
                                    
                                    <td class="memimg"><div class="memimg1" style="background-image:url(<?php if(isset($member['image']) && $member['image']!=''){echo site_url('uploads/thumb/'.$member['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>)"></div></td>
                                    
                                    <td class="activedivname"><?php if($member['status']==1){ ?><div class="activespan"></div><?php }else{ ?><div class="activespan deactivespan"></div><?php } ?><a href="<?=site_url('admin/members/view/'.$member['id'].'')?>" ><?php echo $member['name']; ?></a></td>
                                    
                                    <td><?php if(isset($member['trainername']) && $member['trainername']!=''){ echo $member['trainername']; }else{ echo 'N/A'; } ?></td>
                                    
                                    
                                    <?php if(isset($member['packagedetail']) && !empty($member['packagedetail'])){
                                    $totalfees=calculatefees($member['packagedetail']['fees'],$member['trainer_id'],$member['training_fees'],$member['commission_percentage']);
                                    ?>
                                    <?php } else{
                                    $totalfees=calculatefees($member['fees'],$member['trainer_id'],$member['training_fees'],$member['commission_percentage']);
                                    ?>
                                    <?php } ?>
                                    <td class="feesetup"><?php echo $this->session->userdata['currency_symbol']."".$totalfees; ?></td>
                                    
                                    <td class="feedatesetup"><?php echo date("d-M-y",$member['fee_date']); ?></td>
                                    
                                    
                                   <?php for($i=0;$i<sizeof($member['range_attendences']);$i++){?>
                <td class="<?php if($member['range_attendences'][$i]['attendence'][0]['status']=='Absent'){echo 'att_status_fail';} else{echo 'att_status_succ';} ?>">
                     <?php if($member['range_attendences'][$i]['attendence'][0]['status']=='Absent'){echo 'A';}else{echo 'P';};?>
                </td>

                                   <?php }?>
                                   
                                  <td><?php echo $member['comment']; ?></td> 
                                    
                                   
                                   
                                </tr>
                               
                             
                        <?php endforeach; ?>                                                                                                   

                    </tbody>

                </table>
                
                <?php }?>
            </div><!-- /.box-body -->
        </div>


    </section><!-- /.content -->
</div>


