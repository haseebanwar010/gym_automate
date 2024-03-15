<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<div class="content-wrapper">
  
    
    <section class="content-header">
      <h1>
        Packages
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/packages">Packages</a></li>
        <li class="active">All Packages</li>
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
                <h3 class="box-title">All Packages</h3>
                 
                <a class="add pull-right" href="<?=site_url('admin/packages/add')?>"><button class="btn bg-navy margin addbtn">Add New</button></a>
<!--                <a href="<?=site_url('admin/packages/printpackages')?>" target="_blank" class="btn btn-info pull-right printpckgbtn"><i class="fa fa-print"></i> Print</a>-->
               
            </div>
            <!-- /.box-header -->
          
  
         
            <div class="box-body">
                <table id="packagestable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="desktoptab">Name</th>

                            <th class="desktoptab">Admission Fees</th>

                            <th class="desktoptab">Members</th>
                            <th class="desktoptab">Duration</th>
                            <th class="desktoptab">Fees</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //echo "<pre>"; var_dump($gyms); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($packages as $package): ?>
                        <tr>  
                            <td><?php echo $package['name']; ?></td>
                            <td><?php echo $this->session->userdata['currency_symbol']."".$package['admission_fees']; ?></td>
                            <td><?php echo $package['members']; ?></td>
                            <td><?php echo $package['duration']." Month"; ?></td>
                            <td><?php echo $this->session->userdata['currency_symbol']."".$package['fees']; ?></td>

<td>
    
    
      <div class="btn-group">
          <a href="<?=site_url('admin/packages/edit/'.$package['id'].'')?>"><button type="button" class="btn btn-warning firstbtngroup">Edit</button></a>
          <a data-toggle="modal" data-target="#myModal_<?php echo $package['id']; ?>" href="javascript:;"><button type="button" class="btn btn-danger lastbtngroup">Delete</button></a>
    </div>
                                         
</td>
                              
                            
                             
                            
                           
                            
                                <div class="modal fade" id="myModal_<?php echo $package['id']; ?>" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title color-black">Delete Package</h4>
                                            </div>
                                            <div class="modal-body color-black">
                                                <p>Are you sure you want to delete.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="<?php echo site_url('admin/packages/delete/'.$package['id'])?>" type="button" class="btn btn-info color-black">Yes</a>
                                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- END Modal content-->

                                    </div>
                                </div>

                        </tr> 
                                          
<?php endforeach; ?> 

                    </tbody>

                </table>
            </div><!-- /.box-body -->
        </div>


    </section>
</div>