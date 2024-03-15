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
        Member Attendence
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/members">Members</a></li>
        <li class="active">Member Attendence</li>
      </ol>
    </section>
    <section class="content">

        <div class="box box-warning">
            <div class="box-header customer">
                <h3 class="box-title">Attendence</h3>
                 
                
                
            </div><!-- /.box-header -->
          
  
         
            <div class="box-body">
                
                <table id="" class="table table-striped">
                    
                    <div class="attendencefilters col-sm-12">
                        <div class="row">
                        <form method="post" action="" autocomplete="off">
                        <div class="startfilter col-sm-2">
                            <label>Start Date</label>
                            <input  type="text"  class="form-control datepicker" value="<?php if(isset($_POST['start_date']) && !empty($_POST['start_date'])){echo date('m/d/Y',strtotime($_POST['start_date']));} ?>"  id="" name="start_date" placeholder="">
                        </div>
                        <div class="startfilter col-sm-2">
                            <label>End Date</label>
                            <input  type="text"  class="form-control datepicker" value="<?php if(isset($_POST['end_date']) && !empty($_POST['end_date'])){echo date('m/d/Y',strtotime($_POST['end_date']));} ?>"  id="" name="end_date" placeholder="">
                        </div>
                            <div class="col-sm-2">
                            <button type="submit" class="date_btns btn btn-info attdatesubmitbtn">Submit</button>
                        </div>
                            
                                </form>
                            <div class="btn-group customattfilterbtn">
                            <form method="post" action="">
                                <input type="hidden" name="dayslimit" value="1">
                                
                                <button type="submit" class="date_btns btn btn-info firstbtngroup cfirstbtngroup">Today</button>
                                
                            </form>
                            <form method="post" action="">
                                <input type="hidden" name="dayslimit" value="5">
                                
                                <button type="submit" class="date_btns btn btn-info centerbtnsgroup">Last 5 Days</button>
                                
                            </form>
                            <form method="post" action="">
                                <input type="hidden" name="dayslimit" value="30">
                                
                                <button type="submit" class="date_btns btn btn-info lastbtngroup">Last 1 Month</button>
                                
                            </form>
                            </div>
                        </div>
    </div>  
                    <thead>
                        <tr>
                            <th class="desktoptab">Date</th>                           
                            <th class="desktoptab">Time In</th>
                            <th class="desktoptab">Time Out</th>
                            <th class="desktoptab">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  foreach ($attendences as $attendence):
                        
                        if(empty($attendence['attendence'])){
                            ?>
                        <tr>
                            <td><?php echo $attendence['date']; ?></td>
                            <td>00:00</td>
                            <td>00:00</td>
                            <td class="absentattendence"><span class="label label-danger">Absent</span></td>
                        </tr>
                        
                        <?php } else{ 
                            for($r=0;$r<sizeof($attendence['attendence']);$r++){if($r%2==0){
                                ?>
                        <tr>
                            <td><?php echo $attendence['attendence'][$r]['date']; ?></td>
                            <td><?php echo date('h:i:s A', strtotime($attendence['attendence'][$r]['time_in'])); ?></td>
                             <td><?php if(isset($attendence['attendence'][$r+1]['time_in'])){ echo date('h:i:s A', strtotime($attendence['attendence'][$r+1]['time_in'])); }else{ echo "00:00"; } ?></td>
                             
                            <?php if(isset($attendence['attendence'][$r]['status']) && !empty($attendence['attendence'][$r]['status'])){?>
                            <td class="absentattendence"><span class="label label-danger">Absent</span></td>
                            <?php } else{ ?>
                            <td class="presentattendence"><span class="label label-success">Present</span></td>
                            <?php } ?>
                        </tr>
                        <?php
                            }
                                                                               }
                            ?>
                        
<!--
                        <?php
                              //foreach ($attendence['attendence'] as $singleattendence):   ?>
                        <tr>
                            <td><?php echo $singleattendence['date']; ?></td>
                            <td><?php echo date('h:i:s A', strtotime($singleattendence['time_in'])); ?></td>
                            <td><?php if(!isset($singleattendence['time_out'])){ echo "00:00"; }elseif($singleattendence['time_out']=="00:00"){ echo $singleattendence['time_out']; } else{ echo date('h:i:s A', strtotime($singleattendence['time_out'])); } ?></td>
                            <?php if(isset($singleattendence['status']) && !empty($singleattendence['status'])){?>
                            <td class="absentattendence"><span class="label label-danger">Absent</span></td>
                            <?php } else{ ?>
                            <td class="presentattendence"><span class="label label-success">Present</span></td>
                            <?php } ?>
                        </tr>
                        <?php //endforeach; ?>
-->
                        <?php }
                              endforeach; ?> 

                    </tbody>

                </table>
            </div><!-- /.box-body -->
        </div>


    </section><!-- /.content -->
</div>