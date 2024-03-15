<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>

<div class="content-wrapper">
   
  
         
    
    
    
    
    
    
    
    
    
    
    
    <section class="content-header">
      <h1>
        Members
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/members">Members</a></li>
        <li class="active">Manual Attendence</li>
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
              <h3 class="box-title">Active Members</h3>
                <a href="<?=site_url('admin/members/add')?>"><button type="button" class="btn bg-navy margin addbtn">Add New</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                
                
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="">Id</th>
                    <th class=""></th>
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Gender</th>
                    <?php if($this->session->userdata['show_fees']==1){ ?><th class="desktoptab">Fees</th><?php } ?>
                    <th class="">Fees Date</th>
                    <th class="">Action</th>
                </tr>
                </thead>
                
                    <tbody>
                        <?php //echo "<pre>"; var_dump($gyms); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($members as $member):
                           ?>

                                <tr>
                                    <td><?php echo $member['id']; ?></td>
                                    <td class="memimg"><div class="memimg1" style="background-image:url(<?php if(isset($member['image']) && $member['image']!=''){echo site_url('uploads/thumb/'.$member['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>)"></div></td>
                                    <td><a href="<?=site_url('admin/members/view/'.$member['id'].'')?>" ><?php echo $member['name']; ?></a></td>
                                    <!--<td><?php echo $member['email']; ?></td>-->
                                    <td><?php echo $member['phone']; ?></td>
                                    <td><?php if(isset($member['gender']) && $member['gender']!=""){echo $member['gender'];} else{echo "N/A";} ?></td>
                                    <!--<td><?php echo $member['cnic']; ?></td>
                            <td><?php echo $member['address']; ?></td>-->
                                    <?php if($this->session->userdata['show_fees']==1){ ?>
                                    <?php if(isset($member['packagedetail']) && !empty($member['packagedetail'])){?>
                                        <td><?php echo $this->session->userdata['currency_symbol']."".$member['packagedetail']['fees']; ?></td>
                                    <?php } else{?>
                                        <td><?php echo $this->session->userdata['currency_symbol']."".$member['fees']; ?></td>
                                    <?php } } ?>
                                    
                                    
                                    <td><?php echo date("d-M-y",$member['fee_date']); ?></td>
                                    <td>
                                        
                                        <div class="margin">
                <div class="btn-group">
                  <button type="button" class="btn btn-info">Action</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu customactionmenuitems" role="menu">
                   <li><a href="<?=site_url('admin/members/edit/'.$member['id'].'')?>">Edit</a></li>
                    <li><a data-toggle="modal" data-target="#myModal_<?php echo $member['id']; ?>" href="javascript:;">Delete</a></li>
                    <li><a href="<?=site_url('admin/members/view/'.$member['id'].'')?>" >Detail</a></li>
                      <li><a data-toggle="modal" data-target="#myModalattendence_<?php echo $member['id']; ?>" href="javascript:;">Add Attendence</a></li>
                    <li><a href="<?=site_url('admin/members/viewattendence/'.$member['id'].'')?>" >View Attendence</a></li>
                  </ul>
                                            </div></div>
                                        
                                    </td>






                                    <div class="modal fade" id="myModal_<?php echo $member['id']; ?>" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title color-black">Delete Member</h4>
                                                </div>
                                                <div class="modal-body color-black">
                                                    <p>Are you sure you want to delete.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?php echo site_url('admin/members/delete/'.$member['id'])?>" type="button" class="btn btn-info color-black">Yes</a>
                                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                            <!-- END Modal content-->

                                        </div>
                                    </div>


                                </tr>
                        
                        
                        
                        
                        
                        
                              
                            <div class="modal fade" id="myModalattendence_<?php echo $member['id']; ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Attendence</h4>
              </div>
              <div class="modal-body">
                <form method="post" action="<?=site_url('admin/dashboard/addattendence')?>">
                                       <input type="hidden" name="redirect" value="manual_attendednce">
                                        <div class="modal-body color-black popupfeeform">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="f_name">Date</label>
                                                    <?php $cdate = date('m/d/Y');  ?>
                                                    <input  type="hidden"  class="form-control" value="<?php echo $member['id']; ?>"  id="member_id" name="member_id" placeholder="">
                                                  <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" value="<?php echo $cdate; ?>" class="form-control pull-right datepicker" name="date">
                </div>
                                                </div>
                                            </div>
                                            <div class="bootstrap-timepicker col-md-12">
                <div class="form-group">
                  <label>Time In:</label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="timein">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                </div>
              </div>
                                            <div class="bootstrap-timepicker col-md-12">
                <div class="form-group">
                  <label>Time Out:</label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="timeout">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                </div>
              </div>
                                            

                                        </div>
                                        <div class="modal-footer col-md-12">
                                            <div class="col-md-12">
                                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                             <button type="submit" class="btn btn-info">Submit</button>
                                            </div>
                                        </div>
                                            </form>
              </div>
            
            </div>
          </div>
        </div>
                        
                        

                        <?php endforeach; ?>

                    </tbody>
                <tfoot>
                <tr>
                   <th class="">Id</th>
                    <th class=""></th>
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Gender</th>
                    <?php if($this->session->userdata['show_fees']==1){ ?><th class="desktoptab">Fees</th><?php } ?>
                    <th class="">Fees Date</th>
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
    