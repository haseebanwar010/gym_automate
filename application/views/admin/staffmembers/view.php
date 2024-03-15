<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
  


<?php
$trainercommissionpercentage=$member['commission_percentage'];
?>


    <section class="content-header">
      <h1>
       Staff Member Detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/staffmembers">Staff Members</a></li>
        <li class="active">Staff Member Detail</li>
      </ol>
    </section>
    
    
    
    
    <section class="content">

      <div class="row">
          <div class="col-md-12">
         <?php     
          if(!empty($this->session->flashdata('msg'))){
    
    ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?=$this->session->flashdata('msg')?>
              </div>             
    <?php } ?>
          </div>
          
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php if($member['image']==""){echo site_url('frontend/images/noimage.jpg'); } else{ echo site_url('uploads/thumb/'.$member['image']); }?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php if($member['status']==1){ ?><div class="activespan detailspan"></div><?php }else{ ?><div class="activespan deactivespan detailspan"></div><?php } ?><?php if(isset($member['name']) && $member['name']!=""){echo $member['name'];} else{echo "N/A";} ?></h3>

              <p class="text-muted text-center"><?php if(isset($member['phone']) && $member['phone']!=""){echo $member['phone'];} else{echo "N/A";} ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Joining Date</b> <a class="pull-right"><?php if(isset($member['joining_date']) && $member['joining_date']!=""){echo date("d-M-Y",$member['joining_date']);} else{echo "N/A";} ?></a>
                </li>
                  <li class="list-group-item">
                  <b>CNIC</b> <a class="pull-right"><?php if(isset($member['cnic']) && $member['cnic']!=""){ echo $member['cnic']; } else{echo "N/A";} ?></a>
                </li>
                  <li class="list-group-item">
                    <b>Gender: </b> <a class="pull-right"><?php if(isset($member['gender']) && $member['gender']!=""){echo $member['gender'];} else{echo "N/A";} ?> </a>
                </li>
                  <li class="list-group-item">
                  <b>Salary</b> <a class="pull-right"><?php if(isset($member['salary']) && $member['salary']!=""){ echo $this->session->userdata['currency_symbol']."".$member['salary']; } else{echo "N/A";} ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Training Fees</b> <a class="pull-right"><?php if(isset($member['training_fees']) && $member['training_fees']!=""){ echo $this->session->userdata['currency_symbol']."".$member['training_fees']; } else{echo "N/A";} ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Commission</b> <a class="pull-right"><?php if(isset($member['commission_percentage']) && $member['commission_percentage']!=""){ echo $member['commission_percentage']."%"; } else{echo "N/A";} ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Secondary Name</b> <a class="pull-right"><?php if(isset($member['secondary_name']) && $member['secondary_name']!=""){ echo $member['secondary_name']; } else{echo "N/A";} ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Secondary Phone</b> <a class="pull-right"><?php if(isset($member['secondary_phone']) && $member['secondary_phone']!=""){ echo $member['secondary_phone']; } else{echo "N/A";} ?></a>
                </li>
                  <li class="list-group-item">
                  <b>Address</b> <a class="pull-right"><?php if(isset($member['address']) && $member['address']!=""){ echo $member['address']; } else{echo "N/A";} ?></a>
                </li>
                
              </ul>
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
              <li class="active"><a href="#timeline" data-toggle="tab">Fee History</a></li>
                <li class=""><a href="#addpayment" data-toggle="tab">Add Payment</a></li>
                <li class=""><a href="#assignedmembers" data-toggle="tab">Assigned Members</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="addpayment">
                <section class="custominvoiceprofile">
      
      <!-- info row -->
      <div class="row invoice-info">
        
        <!-- /.col -->
         
        <div class="col-sm-6 invoice-col ulliablack">
            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Total Payable: </b> <a class="pull-right"><?php echo $this->session->userdata['currency_symbol']."".$total_payable_trainer; ?></a>
                </li>
                
            </ul>
            
        </div>
           <div class="col-sm-6 invoice-col ulliablack">
               <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>Pending Amount: </b> <a class="pull-right"><?php echo $this->session->userdata['currency_symbol']."".$paymenthistory['pending_amount']; ?></a>
                </li>
               </ul>
          </div>
        <!-- /.col -->
      </div>
<!--                    <div class="col-sm-12">-->
                        <form method="post" action="">
                        <input type="hidden" name="pending_amount" value="<?php echo $paymenthistory['pending_amount']; ?>">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="f_name">Amount</label>
                                <input required type="number"  class="form-control" max="<?php echo $paymenthistory['pending_amount']; ?>" value="<?php echo $paymenthistory['pending_amount']; ?>"  id="" name="amount" placeholder="Amount..">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="f_name">Comment</label>
                                <input type="text"  class="form-control" value="<?php if(isset($_POST['comment'])){echo $_POST['comment'];} ?>"  id="" name="comment" placeholder="Comment..">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button class="btn bg-navy margin submitbtn" type="submit">Pay</button>
                            </div>
                        </div>
                        </form>
<!--                    </div>-->
                  </section>
              </div>
              <!-- /.tab-pane -->
              <div class="active tab-pane" id="timeline">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Comment</th>
                    <th>Pending Amount</th>
                </tr>
                </thead>
                     <tbody>

<?php foreach ($paymenthistory['payments_hiostory'] as $shistory):  ?>
                      <tr>
                      	<td> <?php echo $shistory['date']; ?></td>
                      	<td><?php echo $this->session->userdata['currency_symbol']."".$shistory['amount']; ?></td>
                      	<td><?php if(isset($shistory['comment']) && $shistory['comment']!=""){echo $shistory['comment'];} else{echo "N/A";} ?></td>
                        <td><?php echo $this->session->userdata['currency_symbol']."".$shistory['remaining_amount']; ?></td>
                      </tr>
<?php endforeach; ?>


                </tbody>
                    <tfoot>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Comment</th>
                    <th>Pending Amount</th>
                </tr>
                </tfoot>
                  </table>
              </div>
                
                
                <div class="tab-pane" id="assignedmembers">
                <table id="" class="table table-bordered table-striped example1">
                <thead>
                <tr>
                    <th class="">Id</th>
                    <th class=""></th>
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Gender</th>
                    <th class="desktoptab">Fees</th>
                    <th class="desktoptab">Training Fees</th>
                    <th class="desktoptab">Commission</th>
                    <th class="">Fees Date</th>
<!--                    <th class="">Trainer Amount</th>-->
                </tr>
                </thead>
                <tbody>
                    <?php foreach ( $assignedmembers as $member): $trainerpercentage=($member['custom_fees']*$trainercommissionpercentage)/100; ?>
                    <tr>
                        <td><?php echo $member['id']; ?></td>
                        <td class="memimg"><div class="memimg1" style="background-image:url(<?php if(isset($member['image']) && $member['image']!=''){echo site_url('uploads/thumb/'.$member['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>)"></div></td>
                        <td class="activedivname"><?php if($member['status']==1){ ?><div class="activespan"></div><?php }else{ ?><div class="activespan deactivespan"></div><?php } ?><a href="<?=site_url('admin/members/view/'.$member['id'].'')?>" ><?php echo $member['name']; ?></a></td>
                        <td><?php echo $member['phone']; ?></td>
                        <td><?php if(isset($member['gender']) && $member['gender']!=""){echo $member['gender'];} else{echo "N/A";} ?></td>
                        <td><?php echo $this->session->userdata['currency_symbol']."".$member['custom_fees']; ?></td>
                        <td><?php if($member['training_fees']!=0){echo $this->session->userdata['currency_symbol']."".$member['training_fees'];}else{ echo "N/A"; } ?></td>
                        <td><?php if($member['commission_percentage']!=0){echo $member['commission_percentage']."%";}else{ echo "N/A"; } ?></td>
                        <td><?php echo date("d-M-y",$member['fee_date']); ?></td>
<!--                        <td><?php echo $this->session->userdata['currency_symbol']."".$trainerpercentage; ?></td>-->
                    </tr>
                    <?php endforeach; ?>


                </tbody>
                    <tfoot>
                <tr>
                    <th class="">Id</th>
                    <th class=""></th>
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Gender</th>
                    <th class="desktoptab">Fees</th>
                    <th class="desktoptab">Training Fees</th>
                    <th class="desktoptab">Commission</th>
                    <th class="">Fees Date</th>
<!--                    <th class="">Trainer Amount</th>-->
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
    
    <!--
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-warning">
              <div class="box-header">
              <h3 class="box-title">Assigned Members</h3>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="">Id</th>
                    <th class=""></th>
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Gender</th>
                    <th class="desktoptab">Fees</th>
                    <th class="">Fees Date</th>
                    <th class="">Trainer Amount</th>
                </tr>
                </thead>
                <tbody>
                   <?php foreach ( $assignedmembers as $member): $trainerpercentage=($member['custom_fees']*$trainercommissionpercentage)/100; ?>
                    <tr>
                        <td><?php echo $member['id']; ?></td>
                        <td class="memimg"><div class="memimg1" style="background-image:url(<?php if(isset($member['image']) && $member['image']!=''){echo site_url('uploads/thumb/'.$member['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>)"></div></td>
                        <td class="activedivname"><?php if($member['status']==1){ ?><div class="activespan"></div><?php }else{ ?><div class="activespan deactivespan"></div><?php } ?><a href="<?=site_url('admin/members/view/'.$member['id'].'')?>" ><?php echo $member['name']; ?></a></td>
                        <td><?php echo $member['phone']; ?></td>
                        <td><?php if(isset($member['gender']) && $member['gender']!=""){echo $member['gender'];} else{echo "N/A";} ?></td>
                        <td><?php echo $this->session->userdata['currency_symbol']."".$member['custom_fees']; ?></td>
                        <td><?php echo date("d-M-y",$member['fee_date']); ?></td>
                        <td><?php echo $this->session->userdata['currency_symbol']."".$trainerpercentage; ?></td>
                                </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                  <th class="">Id</th>
                    <th class=""></th>
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Gender</th>
                    <th class="desktoptab">Fees</th>
                    <th class="">Fees Date</th>
                    <th class="">Trainer Amount</th>
                </tr>
                </tfoot>
                  </table>
            </div>
          </div>
        </div>
        </div>
    </section>
    -->
       
       
      </div><!-- /.content-wrapper -->