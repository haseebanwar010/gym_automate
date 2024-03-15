<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<div class="content-wrapper">
  
    
    <section class="content-header">
      <h1>
        Gyms
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>superadmin/gyms">Gyms</a></li>
        <li class="active">All Gyms</li>
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
                <h3 class="box-title">All Gyms</h3>
                 
                <a class="add pull-right" href="<?=site_url('superadmin/gym/add')?>"><button class="btn bg-navy margin addbtn">Add New</button></a>
               
            </div>
            <!-- /.box-header -->
          
  
         
            <div class="box-body">
                
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="desktoptab">Gym Name</th>
                            <th class="desktoptab">User Name</th>
                            <th class="desktoptab">Phone</th>
                            <th class="desktoptab">Address</th>
                            <th class="desktoptab">Package Type</th>
                            <th class="desktoptab">Payment Criteria Type</th>
                            <th class="desktoptab">Creation date</th>
                            <th class="desktoptab">Logo</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //echo "<pre>"; var_dump($gyms); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($gyms as $gym):

                            $gym['created_date']=strtotime($gym['created_date']);
                            $gym['created_date']=date("Y-M-d",$gym['created_date']);
                            
                            ?>
                        <tr>  
                            <td><?php echo $gym['name']; ?></td>
                            <td><?php echo $gym['user_name']; ?></td>
                            <td><?php echo $gym['phone']; ?></td>
                            <td><?php echo $gym['address']; ?></td>
                            <td><?php if($gym['package_type']==1){echo "Basic";}elseif($gym['package_type']==2){echo "Basic Plus";}elseif($gym['package_type']==3){echo "Advance ";}else{echo "NA";} ?></td>
                            <td><?php if($gym['payment_criteria']==1){echo "Monthly";}elseif($gym['payment_criteria']==2){echo "Half year";}elseif($gym['payment_criteria']==3){echo "yearly";}else{echo "NA";} ?></td>
                            <td><?php if(isset($gym['created_date']) && $gym['created_date']!=""){echo $gym['created_date'];} ?></td>
                            <td><img src="<?php if(isset($gym['image']) && $gym['image']!=""){echo site_url('uploads/thumb/'.$gym['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>">

                             </td>
<td class="minactionwidth">
    
    
     <div class="margin">
                <div class="btn-group">
                  <button type="button" class="btn btn-info">Action</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu customactionmenuitems" role="menu">
                   <li><a href="<?=site_url('superadmin/gym/edit/'.$gym['id'].'')?>">Edit</a></li>
                    <li><a data-toggle="modal" data-target="#myModal_<?php echo $gym['id']; ?>" href="javascript:;">Delete</a></li>
                  </ul>
                                            </div></div>
    
                          
</td>
                               
                            
                             
                            
                           
                            
                                <div class="modal fade" id="myModal_<?php echo $gym['id']; ?>" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title color-black">Delete Gym</h4>
                                            </div>
                                            <div class="modal-body color-black">
                                                <p>Are you sure you want to delete.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="<?php echo site_url('superadmin/gym/delete/'.$gym['id'])?>" type="button" class="btn btn-default color-black">Yes</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- END Modal content-->

                                    </div>
                                </div>


                        </tr> 
                                          
<?php endforeach; ?> 

                    </tbody>

                </table>
                
                
                
                
                
                
                
            </div>
        </div>


    </section>
</div>
