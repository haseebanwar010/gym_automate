

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

        <div class="box">
            <div class="box-header customer">
                <h3 class="box-title"><?php echo $title; ?></h3>
                 
                
                
            </div><!-- /.box-header -->
          
  
         
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="desktoptab">Name</th>
                            <!--<th class="desktoptab">Email</th>-->
                            <th class="desktoptab">Phone</th>
                            <!--<th class="desktoptab">CNIC</th>
                            <th class="desktoptab">Address</th>-->
                            <th class="desktoptab">Fees</th>
                            <th class="desktoptab">Fees Date</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //echo "<pre>"; var_dump($gyms); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($members as $member): ?>
                        <tr>  
                            <td><?php echo $member['name']; ?></td>
                            <!--<td><?php echo $member['email']; ?></td>-->
                            <td><?php echo $member['phone']; ?></td>
                            <!--<td><?php echo $member['cnic']; ?></td>
                            <td><?php echo $member['address']; ?></td>-->
                            <td>Rs<?php echo $member['fees']; ?></td>
                            <td><?php echo date("d-M-y",$member['fee_date']); ?></td>
<td>
                            <a href="<?=site_url('admin/members/edit/'.$member['id'].'')?>">Edit</a> /
                            
                            
                            <a data-toggle="modal" data-target="#myModal_<?php echo $member['id']; ?>" href="javascript:;">Delete</a> /
                            <a href="<?=site_url('admin/members/view/'.$member['id'].'')?>" >Detail</a>/
  <?php if(isset($title) && $title=="Inactive Members"){ ?>  <a data-toggle="modal" data-target="#myinactivefeeModal_<?php echo $member['id']; ?>" href="javascript:;">Pay-Fee+Active</a> <?php } ?>
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
                                                        <input  type="text"  class="form-control" value="<?php echo $member['fees']; ?>"  id="fees" name="fees" placeholder="">
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
                                                <h4 class="modal-title color-black">Delete Patient</h4>
                                            </div>
                                            <div class="modal-body color-black">
                                                <p>Are you sure you want to delete.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="<?php echo site_url('admin/members/delete/'.$member['id'])?>" type="button" class="btn btn-default color-black">Yes</a>
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
            </div><!-- /.box-body -->
        </div>


    </section><!-- /.content -->
</div>