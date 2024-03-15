

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
       
    <!-- Main content -->
    <section class="content">

        <div class="box box-warning">
            <div class="box-header customer">
                <h3 class="box-title"><?php echo $title; ?></h3>
                 
                
                
            </div><!-- /.box-header -->
          
  
         
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="desktoptab">ID</th>
                            <th class="desktoptab memimg"></th>
                            <th class="desktoptab">Name</th>
                            <th class="desktoptab">Phone</th>
                            <th class="desktoptab">Time In</th>
                            <th class="desktoptab">Time Out</th>
                            <th class="desktoptab">Fees Date</th>
                            

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //echo "<pre>"; var_dump($members); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($members as $member): if(!empty($member['member_detail'])){ ?>
                        <tr>
                            <td><?php echo $member['member_detail'][0]['id']; ?></td>
                            <td class="memimg"><div class="listingprofileimg"><img class="" src="<?php if(isset($member['member_detail'][0]['image']) && $member['member_detail'][0]['image']!=""){echo site_url('uploads/thumb/'.$member['member_detail'][0]['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>"></div></td>

                            <td><a href="<?=site_url('admin/members/view/'.$member['member_detail'][0]['id'].'')?>"><?php echo $member['member_detail'][0]['name']; ?></a></td>
                            <td><?php echo $member['member_detail'][0]['phone']; ?></td>
                           <td><?php echo date('h:i:s A', strtotime($member['time_in'])); ?></td>
                            <td><?php if($member['time_out']=="00:00:00" || $member['time_out']=="00:00"){ echo $member['time_out']; } else{ echo date('h:i:s A', strtotime($member['time_out'])); } ?></td>
                            <td><?php echo date('d-M-Y',$member['member_detail'][0]['fee_date']); ?></td>
<td>
    <div class="margin">
                <div class="btn-group">
                  <button type="button" class="btn btn-info">Action</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu customactionmenuitems" role="menu">
                   <li><a href="<?=site_url('admin/members/edit/'.$member['member_detail'][0]['id'].'')?>">Edit</a></li>
                    <li><a data-toggle="modal" data-target="#myModal_<?php echo $member['member_detail'][0]['id']; ?>" href="javascript:;">Delete</a></li>
                    <li><a href="<?=site_url('admin/members/view/'.$member['member_detail'][0]['id'].'')?>" >Detail</a></li>
                    <li><a href="<?=site_url('admin/members/viewattendence/'.$member['member_detail'][0]['id'].'')?>" >View Attendence</a></li>
                    <li><a href="<?=site_url('admin/members/bodycomposition/'.$member['member_detail'][0]['id'].'')?>" >Body Composition & Fitness</a></li>
                  </ul>
                                            </div></div>
    
    
</td>


                        
                           
                            
                                <div class="modal fade" id="myModal_<?php echo $member['member_detail'][0]['id']; ?>" role="dialog">
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
                                                <a href="<?php echo site_url('admin/members/delete/'.$member['member_detail'][0]['id'])?>" type="button" class="btn btn-default color-black">Yes</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- END Modal content-->

                                    </div>
                                </div>

                        </tr> 
                                          
<?php } endforeach; ?> 

                    </tbody>

                </table>
            </div><!-- /.box-body -->
        </div>


    </section><!-- /.content -->
</div>