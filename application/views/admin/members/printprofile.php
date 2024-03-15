
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <!-- Content Header (Page header) -->
    <link rel="stylesheet" href="<?php echo $baseUrl?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $baseUrl?>assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $baseUrl?>assets/dist/css/style.css">
<style>
   
    .table-striped tr td{
        font-size:14px;
    }
    .table-striped tr th{
        font-weight:normal;
    }
</style>

          <section class="invoice">
          <!-- title row -->
          <div class="box-header customer">
                <h3 style="color: #fff !important;" class="box-title">Member Profile</h3>
                
            </div>
             
              <!-- info row -->
          <div class="row ">
          <div class="col-xs-12">
              
            <table class="table table-striped ">
            	<tr>
                    <th>Member Image</th>
                    <td><img src="<?php if($member['image']==""){echo site_url('frontend/images/noimage.jpg'); } else{ echo site_url('uploads/thumb/'.$member['image']); }?>"></td>
                </tr>
                
                <tr>
                    <th>ID</th>
                    <td><?php if(isset($member['id']) && $member['id']!=""){echo $member['id'];} else{echo "N/A";} ?></td>
                </tr>
                <tr>
                    <th>Reference Number</th>
                    <td><?php if(isset($member['refrence_no']) && $member['refrence_no']!=""){echo $member['refrence_no'];} else{echo "N/A";} ?></td>
                </tr>
                <tr>
                    <th>Member Name</th>
                    <td><?php if(isset($member['name']) && $member['name']!=""){echo $member['name'];} else{echo "N/A";} ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                     <td><?php if(isset($member['email']) && $member['email']!=""){echo $member['email'];} else{echo "N/A";} ?></td>
                </tr>

                <tr>   
                    <th>Phone Number</th>
                    <td><?php if(isset($member['phone']) && $member['phone']!=""){echo $member['phone'];} else{echo "N/A";} ?></td>
                </tr>
                <tr>
                    <th>CNIC</th>
                    <td><?php if(isset($member['cnic']) && $member['cnic']!=""){echo $member['cnic'];} else{echo "N/A";} ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php if(isset($member['address']) && $member['address']!=""){echo $member['address'];} else{echo "N/A";} ?></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?php if(isset($member['gender']) && $member['gender']!=""){echo $member['gender'];} else{echo "N/A";} ?></td>
                </tr>
                <tr>

                    <th>Blood Group</th>
                    <td><?php if(isset($member['blood_group']) && $member['blood_group']!=""){echo $member['blood_group'];} else{echo "N/A";} ?></td>
                </tr>

                <tr>
                    <th>Body Weight</th>
                    <td><?php if(isset($member['body_weight']) && $member['body_weight']!=""){echo $member['body_weight']." KG";} else{echo "N/A";} ?></td>
                </tr>
                <tr>
                    <th>Height</th>
                    <td><?php if(isset($member['height']) && $member['height']!=""){echo $member['height']." ft";} else{echo "N/A";} ?></td>
                </tr>
                <tr>
                    <th>Secondary Name</th>
                    <td><?php if(isset($member['secondary_name']) && $member['secondary_name']!=""){echo $member['secondary_name'];} else{echo "N/A";} ?></td>
                </tr>
                <tr>
                    <th>Secondary Phone</th>
                    <td><?php if(isset($member['secondary_phone']) && $member['secondary_phone']!=""){echo $member['secondary_phone'];} else{echo "N/A";} ?></td>
                </tr>
               <?php if(isset($member['package']) && $member['package']=="custom"){?>
                   <tr>
                       <th>Fees</th>
                       <td><?php if(isset($member['fees']) && $member['fees']!=""){echo $this->session->userdata['currency_symbol']."".$member['fees'];} else{echo "N/A";} ?></td>
                   </tr>
                    <tr>
                       <th>Admission Fees</th>
                       <td><?php if(isset($member['admission_fees']) && $member['admission_fees']!=""){echo $this->session->userdata['currency_symbol']."".$member['admission_fees'];} else{echo "N/A";} ?></td>
                   </tr>
                <tr>

                       <th>Duration</th>
                       <td><?php if(isset($member['payment_criteria']) && $member['payment_criteria']!=""){echo $member['payment_criteria'];} else{echo "N/A";} ?> Month</td>
                   </tr>
                
                <?php } else{ ?>
                   <tr>

                       <th>Package</th>
                       <td><?php if(isset($member['packagename']) && $member['packagename']!=""){echo $member['packagename'];} ?></td>
                   </tr>
                <?php } ?>




                <tr>

                    <th>Joining Date</th>
                    <td><?php if(isset($member['joining_date']) && $member['joining_date']!=""){echo date("d-M-y",$member['joining_date']);} else{echo "N/A";} ?></td>
                </tr>

                <tr>
                    <th>Fees Date</th>
                    <td><?php if(isset($member['fee_date']) && $member['fee_date']!=""){echo date("d-M-y",$member['fee_date']);} else{echo "N/A";} ?></td>
                </tr>
                <tr>
                    <th>Comment</th>
                    <td><?php if(isset($member['comment']) && $member['comment']!=""){ echo $member['comment']; } else{echo "N/A";} ?></td>
                </tr>
                
            </table>
            </div>
          </div><!-- /.row -->
			
            <!-- title row -->
          <div class="box-header customer">
                <h3 style="color: #fff !important;" class="box-title">Fee History</h3>

            </div>
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Fee Amount</th>
                    <th>Comment</th>
                  </tr>
                </thead>
                <tbody>
<?php if($member['fees_detail']!=null){
    $history=unserialize($member['fees_detail']);

 ?>
<?php foreach ($history as $shistory):  ?>
                      <tr>
                      	<td> <?php echo date("d-F-Y",$shistory['payment_date']); ?></td>
                      	<td><?php echo $this->session->userdata['currency_symbol']."".$shistory['fees']; ?></td>
                      	<td><?php if(isset($shistory['comment']) && $shistory['comment']!=""){echo $shistory['comment'];} else{echo "N/A";} ?></td>

                      </tr>
<?php endforeach;  } else{ ?>
<!--<p>No History Found</p>-->
                <?php } ?>


                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->



          
        </section>
       
      </div><!-- /.content-wrapper -->