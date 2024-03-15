<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<div class="content-wrapper">
  
    
    <section class="content-header">
      <h1>
        Currencies
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>superadmin/currencies">Currencies</a></li>
        <li class="active">All Currencies</li>
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
                <h3 class="box-title">All Currencies</h3>
                 
                <a class="add pull-right" href="<?=site_url('superadmin/currencies/add')?>"><button class="btn bg-navy margin addbtn">Add New</button></a>
               
            </div>
            <!-- /.box-header -->
          
  
         
            <div class="box-body">
                
              
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="desktoptab">Currency Id</th>
                            <th class="desktoptab">Currency Name</th>
                            <th class="desktoptab">Currency Symbol</th>
                            <th class="desktoptab">Creation date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //echo "<pre>"; var_dump($gyms); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($currencies as $currency):

                            $currency['created_date']=strtotime($currency['created_date']);
                            $currency['created_date']=date("Y-M-d",$currency['created_date']);
                            
                            ?>
                        <tr>  
                            <td><?php echo $currency['id']; ?></td>
                            <td><?php echo $currency['currency_name']; ?></td>
                            <td><?php echo $currency['currency_symbol']; ?></td>
                            <td><?php echo $currency['created_date']; ?></td>

<td>
    
    <div class="margin">
                <div class="btn-group">
                  <button type="button" class="btn btn-info">Action</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu customactionmenuitems" role="menu">
                   <li><a href="<?=site_url('superadmin/currencies/edit/'.$currency['id'].'')?>">Edit</a></li>
                    <li><a data-toggle="modal" data-target="#myModal_<?php echo $currency['id']; ?>" href="javascript:;">Delete</a></li>
                  </ul>
                                            </div></div>
    
</td>
                               
                            
                             
                            
                           
                            
                                <div class="modal fade" id="myModal_<?php echo $currency['id']; ?>" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title color-black">Delete Currency</h4>
                                            </div>
                                            <div class="modal-body color-black">
                                                <p>Are you sure you want to delete.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="<?php echo site_url('superadmin/currencies/delete/'.$currency['id'])?>" type="button" class="btn btn-default color-black">Yes</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- END Modal content-->

                                    </div>
                                </div>
                            </td>
                        </tr>                  
<?php endforeach; ?> 
                    </tbody>

                </table>
                
                
                
                
                
            </div>
        </div>


    </section>
</div>
