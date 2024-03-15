<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <!-- Content Header (Page header) -->
        




          <!--print invoice code start-->

         
    
        <div class="modal fade" id="myModal_print" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title color-black">Print Invoice</h4>
                                            </div>
                                            <div class="modal-body color-black">
                                                <p>Are you sure you want to print the invoive.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="<?php echo site_url('admin/members/printinvoice/'.$member['id'])?>" type="button" class="btn btn-default color-black">Yes</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- END Modal content-->

                                    </div>
                                </div>
    
     <?php if(isset($printstatus) && $printstatus=="ok"){
 
?>
    <script>
        $( document ).ready(function() {
     $('#myModal_print').modal('show');
});
      
    </script>
<?php
           } ?>
    
          <!--print invoice code end-->

<?php
/*echo "<pre>";
var_dump($member);
exit;*/
?>




<?php
    $trainerdetail=array();
if(isset($member['trainer_id']) && $member['trainer_id']!=0){ 
    $trainerdetail=get_trainer_byid($member['trainer_id']); 
}
if(isset($member['packagedetail']) && !empty($member['packagedetail'])){
    $totalfees=calculatefees($member['packagedetail']['fees'],$member['trainer_id'],$member['training_fees'],$member['commission_percentage']);
} else{
    $totalfees=calculatefees($member['fees'],$member['trainer_id'],$member['training_fees'],$member['commission_percentage']);
}
?>


    <section class="content-header">
      <h1>
        Member Detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/members">Members</a></li>
        <li class="active">Member Detail</li>
      </ol>
    </section>
    
    
    
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php if($member['image']==""){echo site_url('frontend/images/noimage.jpg'); } else{ echo site_url('uploads/thumb/'.$member['image']); }?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php if($member['status']==1){ ?><div class="activespan detailspan"></div><?php }else{ ?><div class="activespan deactivespan detailspan"></div><?php } ?><?php if(isset($member['name']) && $member['name']!=""){echo $member['name'];} else{echo "N/A";} ?></h3>

              <p class="text-muted text-center"><?php if(isset($member['phone']) && $member['phone']!=""){echo $member['phone'];} else{echo "N/A";} ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Joining Date</b> <a class="pull-right"><?php if(isset($member['joining_date']) && $member['joining_date']!=""){echo date("d-M-y",$member['joining_date']);} else{echo "N/A";} ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Fees</b> <a class="pull-right"><?php if(isset($member['packagedetail']) && !empty($member['packagedetail'])){ echo $member['packagedetail']['fees']; } elseif(isset($member['fees']) && $member['fees']!=""){echo $this->session->userdata['currency_symbol']."".$member['fees'];} else{echo "N/A";} ?></a>
                </li>
                <li class="list-group-item">
                  <b>Training Fees</b> <a class="pull-right"><?php if(isset($member['training_fees']) && $member['training_fees']!=""){ echo $this->session->userdata['currency_symbol']."".$member['training_fees']; } else{echo "N/A";} ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Commission</b> <a class="pull-right"><?php if(isset($member['commission_percentage']) && $member['commission_percentage']!=""){ echo $member['commission_percentage']."%"; } else{echo "N/A";} ?></a>
                </li>
                <li class="list-group-item">
                  <b>Fees Date</b> <a class="pull-right"><?php if(isset($member['fee_date']) && $member['fee_date']!=""){echo date("d-M-y",$member['fee_date']);} else{echo "N/A";} ?></a>
                </li>
                
              </ul>
                <a data-toggle="modal" class="fee_btn_s1 mypayfeelink btn btn-warning btn-block" data-target="#myModal_<?php echo $member['id']; ?>" href="javascript:;">Pay Fee</a>
            <?php if(isset($gym_detail['sms_counter_limit']) && $gym_detail['sms_counter_limit']>0){ ?>
              <button id="sendreminder" data-tablename="tbl_member_<?php echo $_SESSION['userid']; ?>" data-gymid="<?php echo $_SESSION['userid']; ?>" data-memberphone="<?php echo $member['phone']; ?>" data-memberid="<?php echo $member['id']; ?>" data-membername="<?php if(isset($member['name']) && $member['name']!=""){echo $member['name'];} else{echo "N/A";} ?>" data-gymname="<?php if(isset($_SESSION['username']) && !empty($_SESSION['username'])){echo $_SESSION['username'];} else{echo "N/A";}?>" data-gymphone="<?php if(isset($_SESSION['phone']) && !empty($_SESSION['phone'])){echo $_SESSION['phone'];} else{echo "N/A";}?>" data-feesdate="<?php if(isset($member['fee_date']) && $member['fee_date']!=""){echo date("d-M-y",$member['fee_date']);} else{echo "N/A";} ?>" data-fees="<?php echo $totalfees; ?>" class="fee_btn_s1  reminderbutton btn btn-info btn-block" >Send Reminder</button>
                <?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Detail</a></li>
              <li><a href="#timeline" data-toggle="tab">Fee History</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <section class="custominvoiceprofile">
      
      <!-- info row -->
      <div class="row invoice-info">
        
        <!-- /.col -->
         
        <div class="col-sm-6 invoice-col ulliablack">
            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>ID: </b> <a class="pull-right"><?php if(isset($member['id']) && $member['id']!=""){echo $member['id'];} else{echo "N/A";} ?></a>
                </li>
                <li class="list-group-item">
                    <b>Reference Number: </b> <a class="pull-right"><?php if(isset($member['refrence_no']) && $member['refrence_no']!=""){echo $member['refrence_no'];} else{echo "N/A";} ?></a>
                </li>
                <li class="list-group-item">
                    <b>Email: </b> <a class="pull-right"><?php if(isset($member['email']) && $member['email']!=""){echo $member['email'];} else{echo "N/A";} ?></a>
                </li><li class="list-group-item">
                    <b>CNIC: </b> <a class="pull-right"><?php if(isset($member['cnic']) && $member['cnic']!=""){echo $member['cnic'];} else{echo "N/A";} ?></a>
                </li><li class="list-group-item">
                    <b>Address: </b> <a class="pull-right"><?php if(isset($member['address']) && $member['address']!=""){echo $member['address'];} else{echo "N/A";} ?> </a>
                </li>
                <li class="list-group-item">
                    <b>Trainer: </b> <a class="pull-right"><?php if(!empty($trainerdetail)){ ?> <a target="_blank" class="pull-right" href="<?php echo $baseUrl; ?>admin/staffmembers/view/<?php echo $trainerdetail['id']; ?>"><?php echo $trainerdetail['name']; ?></a><?php }else{ echo "N/A"; } ?> </a>
                </li>
            </ul>
            
        </div>
           <div class="col-sm-6 invoice-col ulliablack">
               <ul class="list-group list-group-unbordered">
                   <li class="list-group-item">
                    <b>Body Weight: </b> <a class="pull-right"> <?php if(isset($member['body_weight']) && $member['body_weight']!=""){echo $member['body_weight']." KG";} else{echo "N/A";} ?></a>
                </li>
                <li class="list-group-item">
                    <b>Height: </b> <a class="pull-right"><?php if(isset($member['height']) && $member['height']!=""){echo $member['height']." ft";} else{echo "N/A";} ?></a>
                </li><li class="list-group-item">
                    <b>Secondary Name: </b> <a class="pull-right"> <?php if(isset($member['secondary_name']) && $member['secondary_name']!=""){echo $member['secondary_name'];} else{echo "N/A";} ?> </a>
                </li><li class="list-group-item">
                    <b>Secondary Phone: </b> <a class="pull-right"><?php if(isset($member['secondary_phone']) && $member['secondary_phone']!=""){echo $member['secondary_phone'];} else{echo "N/A";} ?></a>
                </li>
                <?php if(isset($member['package']) && $member['package']=="custom"){?>
                <li class="list-group-item">
                    <b>Fees: </b> <a class="pull-right"><?php if(isset($member['fees']) && $member['fees']!=""){echo $this->session->userdata['currency_symbol']."".$member['fees'];} else{echo "N/A";} ?> </a>
                </li><li class="list-group-item">
                    <b>Admission Fees: </b> <a class="pull-right"> <?php if(isset($member['admission_fees']) && $member['admission_fees']!=""){echo $this->session->userdata['currency_symbol']."".$member['admission_fees'];} else{echo "N/A";} ?></a>
                </li><li class="list-group-item">
                    <b>Duration: </b> <a class="pull-right"><?php if(isset($member['payment_criteria']) && $member['payment_criteria']!=""){echo $member['payment_criteria'];} else{echo "N/A";} ?> Month </a>
                </li>
                <?php } else{ ?>
                <li class="list-group-item">
                    <b>Package: </b> <a target="_blank" class="pull-right" href="<?php echo site_url('packages'); ?>"><?php if(isset($member['packagename']) && $member['packagename']!=""){echo $member['packagename'];} ?></a>
                </li>
                <?php } ?>
                <li class="list-group-item">
                    <b>Comment: </b> <a class="pull-right"><?php if(isset($member['comment']) && $member['comment']!=""){ echo $member['comment']; } else{echo "N/A";} ?> </a>
                </li>
               </ul>
          </div>
        <!-- /.col -->
      </div>
                  </section>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Date</th>
                    <th>Fee Amount</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
                </thead>
                     <tbody>
<?php if($member['fees_detail']!=null){
    $history=unserialize($member['fees_detail']);
$flag=0;
 ?>
<?php foreach ($history as $shistory):  ?>
                      <tr>
                      	<td> <?php echo date("d-F-Y",$shistory['payment_date']); ?></td>
                      	<td><?php echo $this->session->userdata['currency_symbol']."".$shistory['fees']; ?></td>
                      	<td><?php if(isset($shistory['comment']) && $shistory['comment']!=""){echo $shistory['comment'];} else{echo "N/A";} ?></td>
                          <td>
                             
                              <a href="<?php echo site_url('admin/members/printinvoice/'.$member['id'].'/'.$flag)?>">Print Invoice</a>
                              
                              
                          </td>
                      </tr>
<?php $flag++; endforeach;  } else{ ?>
<!--<p>No History Found</p>-->
                <?php } ?>


                </tbody>
                    <tfoot>
                <tr>
                  <th>Date</th>
                    <th>Fee Amount</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                  </table>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    
    
    
    
    
    
    
    <!-------------------------------------------------------->
    
         
              <div class="modal fade" id="myModal_<?php echo $member['id']; ?>" role="dialog">
                  <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                          <form method="post" action="<?=site_url('admin/members/payfee')?>">
                              <input type="hidden" name="name" value="<?php echo $member['name']; ?>">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title color-black">Pay Fee</h4>
                              </div>
                              <div class="modal-body color-black popupfeeform">

                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label for="f_name">Date</label>
                                          <?php $cdate = date('m/d/Y');  ?>
                                          <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                   <input  type="text"  class="form-control" value="<?php echo $cdate; ?>"  id="datepicker" name="payment_date" placeholder="">
                </div>
                                         
                                          <!-- <input  type="hidden"  class="form-control" value="<?php echo strtotime($cdate); ?>"  id="payment_date" name="payment_date" placeholder="">-->
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label for="f_name">Fees</label>
                                           <div class="input-group form-group">
                <span class="input-group-addon"><?php echo $this->session->userdata['currency_symbol']; ?> </span>
                                               
                                                     <input  type="text"  class="form-control" value="<?php echo $totalfees; ?>"  id="fees" name="fees" placeholder="">
                                                     
              </div>
                                          
                                          <!-- <input  type="hidden"  class="form-control" value="<?php echo $member['fees']; ?>"  id="fees" name="fees" placeholder="">-->
                                          <input  type="hidden"  class="form-control" value="<?php echo $member['id']; ?>"  id="id" name="id" placeholder="">
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label for="f_name">Comment</label>
                                          <textarea type="text"  class="form-control" value=""  id="comment" name="comment" placeholder=""></textarea>
                                      </div>
                                  </div>


                              </div>
                              <div class="modal-footer">
                                  <!--<a href="<?php echo site_url('admin/members/payfee/'.$member['id'])?>" type="button" class="btn btn-default color-black">Submit</a>-->
                                  <div class="col-md-12"><button class="btn btn-info pay_fes" type="submit">Submit</button></div>
                              </div>
                          </form>
                      </div>
                      <!-- END Modal content-->

                  </div>
              </div>
       
       
      </div><!-- /.content-wrapper -->