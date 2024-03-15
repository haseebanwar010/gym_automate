<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php 
    
    ?>
    
         
   
          <section class="content-header">
      <h1>
        All Expenses
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>expenses">All Expenses</a></li>
        <li class="active">All Expenses</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
   <?php 
               if(!empty($this->session->flashdata('error_msg'))){

    ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <?=$this->session->flashdata('error_msg')?>
              </div>
 
    <?php } ?>  
             <?php
          
          if(!empty($this->session->flashdata('msg'))){
    
    ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?=$this->session->flashdata('msg')?>
              </div>             
    <?php } ?>
            
        
        <div class="box box-warning">
        
  <div class="box-header customer">
                <h3 class="box-title">Add Expenses</h3>
                </div>
        <div class="box-body">
            <div class="expensesformwrapper">
                <form method="post" action="<?=site_url('admin/expenses/addexpenses')?>" class="addexpensesform">
                    <div class="dateselectorforexpense dateselectorforexpense_1 col-sm-6" >
                        <label>Date</label>
                        <?php $currentdate=date('m/d/Y'); ?>
                        <input type="text"  class="form-control datepicker" value="<?php echo $currentdate; ?>"  id="" name="expense_date" placeholder="">
                    </div>
                    <div class="addexpenses addexpenses_1 col-sm-12">
                        <label class="mainheadinglabel main_hds">Expenses</label>
                        
                        <ul id="addexpensesli">
                            <li>
                                <div class="col-sm-6">
                                    <label>Expense Title</label>
                                    <input class="form-control" type="text" required name="expense_title0">
                                </div>
                                 <div class="col-sm-6">
                                    <label>Expense Amount</label>
                                    <input class="form-control" type="text" required name="expense_amount0">
                                </div>
                            </li>
                            <input type="hidden" name="licounter" value="0" id="licounter">
                           
                        </ul>
                        <button id="expenseadd" type="button" class="btn btn-info defaulprimary">Add Expense</button>
                    </div>
                    
                    <div class="col-lg-12 customnopaddleft12">
                    <div class="form-group">
                        <button class="btn bg-navy margin submitbtn" type="submit">Submit</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        </div>
        
        
        <div class="box box-success">
            <div class="box-header customer">
                <h3 class="box-title">Expenses</h3>
                 
                <!--<a class="add pull-right" href="<?=site_url('admin/packages/add')?>"><i class="fa fa-user-plus"></i>Add New</a>
                <a class="add pull-right mprintbtnintitle" href="<?=site_url('admin/packages/printpackages')?>"><i class="fa fa-print" aria-hidden="true"></i>
                    Print</a>-->
            </div>
            <!-- /.box-header -->
          
  
         
            <div class="box-body">
                <table id="" class="table table-bordered table-striped dataTable ">
                    
                    
                    <div class="attendencefilters attendencefilters_1 col-sm-6">
                        <div class="row">
                        <form method="post" action="" >
                        <div class="startfilter col-sm-4">
                            <label>Start Date</label>
                            <input  type="text"  class="form-control monthpicker" value="<?php if(isset($_POST['start_date']) && !empty($_POST['start_date'])){echo date('F Y',strtotime($_POST['start_date']));} else{echo date("F Y");} ?>"  id="" name="start_date" placeholder="">
                        </div>
                        <div class="startfilter col-sm-4">
                            <label>End Date</label>
                            <input  type="text"  class="form-control monthpicker" value="<?php if(isset($_POST['end_date']) && !empty($_POST['end_date'])){echo date('F Y',strtotime($_POST['end_date']));} else{echo date("F Y");} ?>"  id="" name="end_date" placeholder="">
                        </div>
                            <div class="col-sm-4">
                            <button type="submit" class="btn bg-navy margin submitbtn filterdateexpbtn">Submit</button>
                        </div>
                            
                                </form>
                        </div>
    </div>  
                    
                    
                    
                    <thead>
                        <tr>
                            <th class="desktoptab">Expense Title</th>
                            <th class="desktoptab">Expense Amount</th>
                            <th class="desktoptab">Expense Date</th>
                            <th class="desktoptab">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($expenses)){ ?>
                        <tr class="nrfound"><td>No Record Found</td></tr>
<?php }else{ $flag=0;
                        foreach ($expenses as $expense): 

                   $expense['expenses']=unserialize($expense['expenses']);
                   foreach($expense['expenses'] as $singleexpense):
                
                   
                        ?>
                      <tr>  
                            <td><?php echo $singleexpense['expense_title']; ?></td>
                            <td><?php echo $this->session->userdata['currency_symbol']."".$singleexpense['expense_amount']; ?></td>
                            <td><?php echo date('d-M-Y',strtotime($expense['expense_date'])); ?></td>
                            <td>
                                   <div class="btn-group">
          <a href="<?=site_url('admin/expenses/edit/'.$expense['id'].'')?>"><button type="button" class="btn btn-warning firstbtngroup">Edit</button></a>
          <a data-toggle="modal" data-target="#myModal_<?php echo $flag.$expense['id']; ?>" href="javascript:;"><button type="button" class="btn btn-danger lastbtngroup">Delete</button></a>
    </div>
                                 
                            </td>
                                <div class="modal fade" id="myModal_<?php echo $flag.$expense['id']; ?>" role="dialog">
                                    <div class="modal-dialog">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title color-black">Delete Expense</h4>
                                            </div>
                                            <div class="modal-body color-black">
                                                <p>Are you sure you want to delete.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="<?php echo site_url('admin/expenses/delete/'.$expense['id'].'/'.$singleexpense['expense_title'].'/'.$singleexpense['expense_amount'].'/'.strtotime($expense['expense_date']))?>" type="button" class="btn btn-info color-black ">Yes</a>
                                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>


                          
                        </tr> 
                                          
<?php $flag++; endforeach; endforeach; } ?> 
  
                    </tbody>

                </table>
            </div>
            
            
          
            
            
        </div>
    </section><!-- /.content -->
</div>


<script>
    $('document').ready(function(){
   
        $( "#expenseadd" ).click(function() {
            var licounter=$('#licounter').val();
            licounter++;
            
            $('#addexpensesli').append('<li><div class="col-sm-6"><label>Expense Title</label><input class="form-control" type="text" required name="expense_title'+licounter+'"></div><div class="col-sm-6"><label>Expense Amount</label><input class="form-control" type="text" required name="expense_amount'+licounter+'"></div></li>');
            $('#licounter').val(licounter);
        });
    });
</script>