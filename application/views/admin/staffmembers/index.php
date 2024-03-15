<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>

<div class="content-wrapper">
   
    <section class="content-header">
      <h1>
        Staff Members
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/staffmembers">Staff Members</a></li>
        <li class="active">All Staff Members</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
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
            <div class="box-header">
              <h3 class="box-title">All Staff Members</h3>
                <a href="<?=site_url('admin/staffmembers/add')?>"><button type="button" class="btn bg-navy margin addbtn">Add New</button></a>
            </div>
            <div class="box-body">
                
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="">Id</th>
                    <th class="">Ref#ID</th>
                    <th class=""></th>
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Gender</th>
                    <th class="">CNIC</th>
                    <th class="">Action</th>
                </tr>
                </thead>
                
                    <tbody>
                        <?php
                        foreach ($staff_members as $member):
                           ?>

                                <tr>
                                    <td><?php echo $member['id']; ?></td>
                                    
                                    <?php if($member['refrence_no']==''){ ?>
                                    <td>N/A</td>
                                    <?php } else{ ?>
                                    <td><?php echo $member['refrence_no']; ?></td>
                                    <?php } ?>
                                    
                                    <td class="memimg"><div class="memimg1" style="background-image:url(<?php if(isset($member['image']) && $member['image']!=''){echo site_url('uploads/thumb/'.$member['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>)"></div></td>
                                    <td class="activedivname"><?php if($member['status']==1){ ?><div class="activespan"></div><?php }else{ ?><div class="activespan deactivespan"></div><?php } ?><a href="<?=site_url('admin/staffmembers/view/'.$member['id'].'')?>" ><?php echo $member['name']; ?></a></td>
                                    <td><?php echo $member['phone']; ?></td>
                                    <td><?php if(isset($member['gender']) && $member['gender']!=""){echo $member['gender'];} else{echo "N/A";} ?></td>
                                    <td><?php echo $member['cnic']; ?></td>
                                    <td>
                                        <div class="margin">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info">Action</button>
                                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu customactionmenuitems" role="menu">
                                                    <li><a href="<?=site_url('admin/staffmembers/edit/'.$member['id'].'')?>">Edit</a></li>
                                                    <li><a data-toggle="modal" data-target="#myModal_<?php echo $member['id']; ?>" href="javascript:;">Delete</a></li>
                                                    <li><a href="<?=site_url('admin/staffmembers/view/'.$member['id'].'')?>">Detail</a></li>
                                                    <li><a href="<?=site_url('admin/members/viewattendence/'.$member['id'].'')?>" >View Attendence</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <div class="modal fade" id="myModal_<?php echo $member['id']; ?>" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title color-black">Delete Member</h4>
                                                </div>
                                                <div class="modal-body color-black">
                                                    <p>Are you sure you want to delete.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?php echo site_url('admin/staffmembers/delete/'.$member['id'])?>" type="button" class="btn btn-info color-black">Yes</a>
                                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                        <?php endforeach; ?>

                    </tbody>
                <tfoot>
                <tr>
                   <th class="">Id</th>
                    <th class=""></th>
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Gender</th>
                    <th class="">CNIC</th>
                    <th class="">Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        </div>
    </section>
</div>
   