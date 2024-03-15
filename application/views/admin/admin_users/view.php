
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        
        
        <section class="invoice">
          <!-- title row -->
          <div class="box-header customer">
                <h3 class="box-title">Customer Profile</h3>
                
            </div>
          <!-- info row -->
          <div class="row ">
          <div class="col-xs-12">
            <table class="table table-striped ">
            	<tr>
                    <th> Name</th>
                    <td><?=$users['first_name'].' '.$users['last_name']?></td>
                </tr>
                <tr>
                    <th>Email</th>
                     <td><?=$users['email']?></td>
                </tr>
               
                <tr>
                    
                    <th>Phone Number</th>
                    <td><?=$users['phone']?></td>
                </tr>
                
                <tr>
                    
                    <th>Address</th>
                    <td><?=$users['address']?></td>
                </tr>
               
                <tr>
                    
                    <th>Account type</th>
                    <td><?=$users['acc_type']?></td>
                </tr>
                 <tr>
                    
                    <th>Company Name</th>
                    <td><?=$users['company_name']?></td>
                </tr>
                <tr>
                    
                    <th>Type</th>
                    <td><?=$users['acc_type']?></td>
                </tr>
                 <tr>
                    
                    <th>Notes</th>
                    <td><?=$users['notes']?></td>
                </tr>
                <tr>
                
                    
                    <th>Status</th>
                    <td><a href="<?php echo base_url()."admin/Users/UpdateStatus/".$users['id']."/".$users['status']?>">
                                    <?php if($users['status']=='disapproved'){ echo 'Disable';}else{ echo $users['status'];}?>
                                </a></td>
                </tr>
                <tr>
                
                    
                    <th>Attachment</th>
                    <?php if(isset($users['attachment']) && $users['attachment']!=null){?>
                    <td><a href="<?php echo  base_url()?>assets/uploads/attachments/<?php echo $users['attachment']; ?>" download>Download File</a></td>
                    <?php } else{ ?>
                    <td>NA</td>
                    <?php } ?>
                </tr>
                
            </table>
            </div>
          </div><!-- /.row -->
			

          
        </section>
       
      </div><!-- /.content-wrapper -->