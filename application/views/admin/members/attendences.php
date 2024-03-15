<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
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
                 
                
                
            </div><!-- /.box-header -->
          
  
         
            <div class="box-body">
                
                <table id="example1" class="table">
                    
                    <div class="attendencefilters col-sm-12">
                        <div class="row">
                        <form method="post" action="" autocomplete="off" class="customformfilter2">
                        <div class="startfilter col-sm-2">
                            <label>Date</label>
                            <input  type="text"  class="form-control datepicker" value="<?php if(isset($_POST['start_date']) && !empty($_POST['start_date'])){echo date('m/d/Y',strtotime($_POST['start_date']));} ?>"  id="" name="start_date" placeholder="">
                        </div>
<!--
                        <div class="startfilter col-sm-2">
                            <label>End Date</label>
                            <input  type="text"  class="form-control datepicker" value="<?php if(isset($_POST['end_date']) && !empty($_POST['end_date'])){echo date('m/d/Y',strtotime($_POST['end_date']));} ?>"  id="" name="end_date" placeholder="">
                        </div>
-->
                            <div class="col-sm-2">
                            <button class="btn bg-navy margin submitbtn attformsumb" type="submit">Submit</button>
                        </div>
                            
                                </form>
                            
<!--
                            <form method="post" action="">
                                <input type="hidden" name="dayslimit" value="1">
                                <div class="col-sm-2">
                                <button type="submit" class="date_btns">Today</button>
                                </div>
                            </form>
                            <form method="post" action="">
                                <input type="hidden" name="dayslimit" value="5">
                                <div class="col-sm-2">
                                <button type="submit" class="date_btns">Last 5 Days</button>
                                </div>
                            </form>
                            <form method="post" action="">
                                <input type="hidden" name="dayslimit" value="30">
                                <div class="col-sm-2">
                                <button type="submit" class="date_btns">Last 1 Month</button>
                                </div>
                            </form>
-->
                        </div>
    </div>  
                    <thead>
                        <tr>
                            <th class="desktoptab">ID</th>                           
                            <th class="desktoptab"></th>                           
                            <th class="desktoptab">Name</th>                           
                            <th class="desktoptab">Phone</th>                           
                            <th class="desktoptab">Date</th>                           
                            <th class="desktoptab">Time In</th>
                            <th class="desktoptab">Time Out</th>
                            <th class="desktoptab">Fees Date</th>
                            <th class="desktoptab">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendences as $attendence):
                        
                       
                              foreach ($attendence['attendence'] as $singleattendence): if(!empty($singleattendence['member_detail'])){   ?>
                        <tr>
                            <td><?php echo $singleattendence['member_detail']['id']; ?></td>
                            <td class="memimg"><div class="listingprofileimg"><img class="" src="<?php if(isset($singleattendence['member_detail']['image']) && $singleattendence['member_detail']['image']!=""){echo site_url('uploads/thumb/'.$singleattendence['member_detail']['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>"></div></td>
                            <td><?php echo $singleattendence['member_detail']['name']; ?></td>
                            <td><?php echo $singleattendence['member_detail']['phone']; ?></td>
                            <td><?php echo $singleattendence['date']; ?></td>
                            <td><?php echo date('h:i:s A', strtotime($singleattendence['time_in'])); ?></td>
                            <td><?php if($singleattendence['time_out']=="00:00"){ echo $singleattendence['time_out']; } else{ echo date('h:i:s A', strtotime($singleattendence['time_out'])); } ?></td>
                            <td><?php echo date('d-M-Y',$singleattendence['member_detail']['fee_date']); ?></td>
                            <?php if(isset($singleattendence['status']) && !empty($singleattendence['status'])){?>
                            <td class=""><span class="label label-danger">Absent</span></td>
                            <?php } else{ ?>
                            <td class=""><span class="label label-success">Present</span></td>
                            <?php } ?>
                        </tr>
                        <?php } endforeach;
                        
                              endforeach; ?> 

                    </tbody>

                </table>
            </div><!-- /.box-body -->
        </div>


    </section><!-- /.content -->
</div>