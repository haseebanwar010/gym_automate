
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
                    <th>Customer Name</th>
                    <td><?=$customer['f_name'].' '.$customer['l_name']?></td>
                </tr>
                <tr>
                    <th>Email</th>
                     <td><?=$customer['email1']?></td>
                </tr>
                <tr>                    
                    <th>Alternate Email</th>
                    <td><?=$customer['email2']?></td>
                </tr>
                <tr>
                    
                    <th>Phone Number</th>
                    <td><?=$customer['phone1']?></td>
                </tr>
                <tr>
                    
                    <th>Alternate Phone Number</th>
                    <td><?=$customer['phone2']?></td>
                </tr>
                <tr>
                    
                    <th>Address</th>
                    <td><?=$customer['address1']?><br /><?=$customer['city_name']?>, <?=$customer['state_name']?>, <?=$customer['country_name']?></td>
                </tr>
               
                <tr>
                    
                    <th>Comments</th>
                    <td><?=$customer['comments']?></td>
                </tr>
                
            </table>
            </div>
          </div><!-- /.row -->
			
            <!-- title row -->
          <div class="box-header customer">
                <h3 class="box-title">Tickets</h3>
                
            </div>
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Ticket ID</th>
                    <th>Subject</th>
                    <th>Problem Type</th>
                    <th>Created</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ticket): ?>
                      <tr>     
                      	<td><?=$ticket['ticket_id']?></td>    
                        <td><?=$ticket['subject']?></td> 
                        <td><?php switch($ticket['problem_type']){case 1: echo 'Software'; break; case 2: echo 'Hardware'; break; }?></td> 
                        <td><?=date('d F, Y', strtotime($ticket['created']))?></td> 
                        <td><?php switch($ticket['status']){case 1: echo 'Open'; break; case 2: echo 'In Progress'; break; case 3: echo 'Repair Done'; break; case 4: echo 'Ready to pickup'; break; case 5: echo 'Not Repairable'; break; }?></td> 
                       
                        <td><?php  $numDays = ceil(abs(date('Y-m-d') - $ticket['last_updated'])/60/60/24); 
						echo ($numDays <= 1 ? 'Today' : ($numDays-1).' Day(s) ago'); ?></td> 
                        
                      </tr> 
                    <?php endforeach; ?>
                    <?php if(count($tickets) < 1){ ?>
                    	<tr>
                        	<td colspan="6">No record found!</td>
                        </tr>
                    <?php } ?> 
                  
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="box-header customer">
                <h3 class="box-title">Invoices</h3>
                
            </div>
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Invoice ID</th>
                        <th>Ticket</th>
                        <th>Description</th>
                        <th>Sub Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                      <tr>     
                      	<td><?=$invoice['invoice_id']?></td>  
                        <td><?=$invoice['subject']?></td> 
                        <td><?=$invoice['description']?></td> 
                        <td>$<?=$invoice['tamount']?></td> 
                        
                       
                      </tr> 
                    <?php endforeach; ?>                       
                    <?php if(count($invoices) < 1){ ?>
                    	<tr>
                        	<td colspan="4">No record found!</td>
                        </tr>
                    <?php } ?>         
                      
                    </tbody>
                    
                  </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          
        </section>
       
      </div><!-- /.content-wrapper -->