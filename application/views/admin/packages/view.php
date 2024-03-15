
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        
        
        <section class="invoice">
          <!-- title row -->
          <div class="box-header customer">
                <h3 class="box-title">Member Profile</h3>
                
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

                    <th>Blood Group</th>
                    <td><?php if(isset($member['blood_group']) && $member['blood_group']!=""){echo $member['blood_group'];} else{echo "N/A";} ?></td>
                </tr>

                <tr>

                    <th>Body Weight</th>
                    <td><?php if(isset($member['body_weight']) && $member['body_weight']!=""){echo $member['body_weight']." KG";} else{echo "N/A";} ?></td>
                </tr>

                <tr>
                    
                    <th>Fees</th>
                    <td>Rs<?php if(isset($member['fees']) && $member['fees']!=""){echo $member['fees'];} else{echo "N/A";} ?></td>
                </tr>
                <tr>

                    <th>Fees Date</th>
                    <td><?php if(isset($member['fee_date']) && $member['fee_date']!=""){echo date("d-M-y",$member['fee_date']);} else{echo "N/A";} ?></td>
                </tr>
                
            </table>
            </div>
          </div><!-- /.row -->
			
            <!-- title row -->
          <div class="box-header customer">
                <h3 class="box-title">Fee History</h3>

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
                      	<td>Rs<?php echo $shistory['fees']; ?></td>
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