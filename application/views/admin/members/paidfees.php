<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php 
    
    ?>
    
         
     <?php
          
          if(!empty($this->session->flashdata('msg'))){
    
    ?>
    <section class="msg">
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?=$this->session->flashdata('msg')?>
        </div>   
    </section>                 
    <?php } ?>
     <section class="content-header">
      <h1>
        <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>members">Members</a></li>
        <li class="active">All <?php echo $title; ?></li>
      </ol>
    </section>    
    <!-- Main content -->
    <section class="content">

        <div class="box box-warning">
            <div class="box-header customer">
                <h3 class="box-title"><?php echo $title; ?></h3>
                 
                
                
            </div><!-- /.box-header -->
          
  
         
            <div class="box-body">
                 <div class="memberfilterwrapper">
                
                <form method="post" action="" class="customformidfilter">
                    <input class="form-control" placeholder="Search By Id" type="text" name="id" id="idseacrh" value="<?php if(isset($_POST['id'])){ echo $_POST['id']; } ?>">
                    <button class="btn btn-info" type="submit">Submit</button>
                </form>
                </div>
                <table id="membertypes" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="desktoptab">ID</th>
                            <?php if($this->session->userdata['referncenumber_status']==true){ ?><th class="">Ref#ID</th><?php } ?>
                            <th class="desktoptab memimg"></th>
                            <th class="desktoptab">Name</th>
                            <!--<th class="desktoptab">Email</th>-->
          <?php if($this->session->userdata['show_phone']==1){ ?><th class="desktoptab">Phone</th><?php } ?>
                            <!--<th class="desktoptab">CNIC</th>
                            <th class="desktoptab">Address</th>-->
                            <?php if($this->session->userdata['show_fees']==1){ ?><th class="desktoptab">Fees</th><?php } ?>
                            <th class="desktoptab">Fees Date</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //echo "<pre>"; var_dump($members); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($members as $member): ?>
                        <tr>
                            <td><?php echo $member['id']; ?></td>
                            <?php if($this->session->userdata['referncenumber_status']==true){ if($member['refrence_no']==''){ ?>
                                    <td>N/A</td>
                                    <?php }else{ ?>
                                    <td><?php echo $member['refrence_no']; ?></td>
                                    <?php }} ?>
                            <td class="memimg"><div class="memimg1" style="background-image:url(<?php if(isset($member['image']) && $member['image']!=''){echo site_url('uploads/thumb/'.$member['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>)"></div></td>

                            <td class="activedivname"><?php if($member['status']==1){ ?><div class="activespan"></div><?php }else{ ?><div class="activespan deactivespan"></div><?php } ?><a href="<?=site_url('admin/members/view/'.$member['id'].'')?>" ><?php echo $member['name']; ?></a></td>
                            <!--<td><?php echo $member['email']; ?></td>-->
                                    <?php if($this->session->userdata['show_phone']==1){ ?><td><?php echo $member['phone']; ?></td><?php } ?>
                            <!--<td><?php echo $member['cnic']; ?></td>
                            <td><?php echo $member['address']; ?></td>-->
                            <?php if($this->session->userdata['show_fees']==1){ ?>
                            <?php if(isset($member['packagedetail']) && !empty($member['packagedetail'])){
                                    $totalfees=calculatefees($member['packagedetail']['fees'],$member['trainer_id'],$member['training_fees'],$member['commission_percentage']);
                                    ?>
                                    <?php } else{
                                    $totalfees=calculatefees($member['fees'],$member['trainer_id'],$member['training_fees'],$member['commission_percentage']);
                                    ?>
                                    <?php } ?>
                            <td><?php echo $this->session->userdata['currency_symbol']."".$totalfees; ?></td>
                            <?php } ?>
                            <td><?php echo date("d-M-y",$member['fee_date']); ?></td>
<td>
    <div class="btn-group">
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
                    <li><a href="<?=site_url('admin/members/viewattendence/'.$member['id'].'')?>" >View Attendence</a></li>
                    <li><a href="<?=site_url('admin/members/bodycomposition/'.$member['id'].'')?>" >Body Composition & Fitness</a></li>
                  </ul>
                                            </div></div>
                                        </div>
</td>


                            <div class="modal fade" id="myinactivefeeModal_<?php echo $member['id']; ?>" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <form method="post" action="<?=site_url('admin/members/payinactivefee')?>">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title color-black">Pay Fee</h4>
                                            </div>
                                            <div class="modal-body color-black popupfeeform">

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="f_name">Date</label>
                                                        <?php $cdate = date('Y-m-d');  ?>
                                                        <input  type="text"  class="form-control" value="<?php echo $cdate; ?>"  id="datepicker" name="payment_date" placeholder="">
                                                        <!-- <input  type="hidden"  class="form-control" value="<?php echo strtotime($cdate); ?>"  id="payment_date" name="payment_date" placeholder="">-->
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="f_name">Fees</label>
                                                        <input  type="text"  class="form-control" value="<?php if(isset($member['packagedetail']) && !empty($member['packagedetail'])){echo $member['packagedetail']['fees'];}else{ echo $member['fees']; } ?>"  id="fees" name="fees" placeholder="">
                                                        <!-- <input  type="hidden"  class="form-control" value="<?php echo $upcomfee['fees']; ?>"  id="fees" name="fees" placeholder="">-->
                                                        <input  type="hidden"  class="form-control" value="<?php echo $member['id']; ?>"  id="id" name="id" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="f_name">Comment</label>
                                                        <textarea type="text"  class="form-control" value=""  id="comment" name="comment" placeholder=""></textarea>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <!--<a href="<?php echo site_url('admin/members/payfee/'.$upcomfee['id'])?>" type="button" class="btn btn-default color-black">Submit</a>-->
                                                <button class="btn btn-default" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END Modal content-->

                                </div>
                            </div>


                             
                            
                           
                            
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
                                          
<?php endforeach; ?> 

                    </tbody>

                </table>
            </div><!-- /.box-body -->
        </div>


    </section><!-- /.content -->
</div>