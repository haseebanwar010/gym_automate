
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?> <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
      <h1>
        Profit & Loss
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>balancesheet">Profit & Loss</a></li>
        <li class="active">All Profit & Loss</li>
      </ol>
    </section>
        
        <section class="invoice box-warning">
          <!-- title row -->
          <div class="box-header customer">
                <h3 class="box-title">Profit & Loss Statement</h3>
                
            </div>
          <!-- info row -->
          <div class="row ">
          <div class="col-xs-12">
            <table class="table table-striped profitlosstable">
                
                <div class="attendencefilters col-sm-12 profitlossfilter">
                        <div class="row">
                        <form method="post" action="">
                        <div class="startfilter">
                            <label>Date: </label>
                            <input  type="text"  class="form-control monthpicker" value="<?php if(isset($_POST['date']) && !empty($_POST['date'])){echo date('F Y',strtotime($_POST['date']));}else{echo date("F Y");} ?>"  id="" name="date" placeholder="">
                            <div class=" profitlossfilterbtn profitlossfilterbtninline">
                            <button type="submit" class="date_btns btn bg-navy margin submitbtn">Submit</button>
                        </div>
                        </div>
                        
                            
                            
                                </form>
                        </div>
    </div>  
                   
                
                
                
            	<tr>
                    <th>Gross Income</th>
                    <td></td>
                    <th class="marginrightbold"><?php if(!empty($totals)){echo $this->session->userdata['currency_symbol']."".number_format($totals[0]['total_income']);} else{echo "N/A";} ?></th>
                    
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th style="font-weight:bold;">Expenses</th>
                    <td></td>
                    <td></td>
                   
                </tr>
                 
                <?php
                foreach($expenses as $expense){ 
                    foreach($expense['expenses'] as $singleexpense){
                ?>
                    <tr><td class="subexpenses"><?php echo $singleexpense['expense_title']; ?></td><td></td><td class="subexpensesamount"><?php echo $this->session->userdata['currency_symbol']."".number_format($singleexpense['expense_amount']); ?></td></tr>
                <?php } }
                ?>
               
                
                  
                 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>   
                <tr>
                    <th>Total Expenses</th>
                    <td></td>
                     <th class="marginrightbold"><?php  if(!empty($totals)){echo $this->session->userdata['currency_symbol']."".number_format($totals[0]['total_expence']); } else{ echo "N/A"; } ?></th>
                     
                </tr>
                <tr>
                    
                    <th style="font-weight:bold;">Net Income</th>
                    <td></td>
                    <?php  if(!empty($totals)){$profitdata=$totals[0]['total_income']-$totals[0]['total_expence']; }else{ $profitdata=0; }  ?>
                    <th class="marginrightbold"><?php if(!empty($totals)){ if($profitdata>0){echo $this->session->userdata['currency_symbol'].number_format($profitdata);} else{ echo "(".$this->session->userdata['currency_symbol'].number_format(abs($profitdata)).")"; }} else{echo "N/A";} ?></th>
                    
                </tr>
              
                
            </table>
            </div>
          </div><!-- /.row -->
			
            <!-- title row -->
          

          
        </section>
       
      </div><!-- /.content-wrapper -->