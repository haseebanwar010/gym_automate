<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?> 
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        
     
        <?php if(validation_errors()){ ?>
        	<section class="msg">
                <div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Errors!</strong><br /><?php echo validation_errors(); ?>
                </div>   
            </section> 
        	
        <?php } ?>
          <section class="content-header">
      <h1>
        Update Expense
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>expenses">Expenses</a></li>
        <li class="active">Update Expense</li>
      </ol>
    </section>
        <!-- Main content -->
        <section class="content">
             <div class="box box-warning">
        <div class="box-header customer">
                <h3 class="box-title">Update Expense</h3>
                
            </div>
          <div class="box-body">
            <form role="form" action="<?=site_url('admin/expenses/edit/'.$expenses[0]['id'].'')?>" method="post" enctype="multipart/form-data">
            <input name="id" type="hidden" value="<?php echo $expenses[0]['id']; ?>">
            
                
                
                <?php for($i=0;$i<sizeof($expenses[0]['expenses']);$i++){ ?>
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Expense Title</label>
                        <input type="text" class="form-control" required="required" value="<?php echo $expenses[0]['expenses'][$i]['expense_title']; ?>"  id="" name="expense_title<?php echo $i; ?>" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Expense Amount</label>
                        <input type="number" required="required" class="form-control" value="<?php echo $expenses[0]['expenses'][$i]['expense_amount']; ?>"  id="" name="expense_amount<?php echo $i; ?>" placeholder="">
                    </div>
                </div>
                
               <?php } ?>
                <input type="hidden" name="expense_date" value="<?php echo$expenses[0]['expense_date']; ?>">
                <input type="hidden" name="numberofpairs" value="<?php echo sizeof($expenses[0]['expenses']); ?>">

                 <div class="col-lg-12">
                    <div class="form-group">
                        <button class="btn bg-navy margin submitbtn" type="submit">Submit</button>
                    </div>
                </div>
            
            </form>
          </div> 
          </div> 
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
       