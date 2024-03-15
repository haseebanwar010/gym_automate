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
        All Users
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>users">Users</a></li>
        <li class="active">All Users</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
<?php
          
          if(!empty($this->session->flashdata('msg'))){
    
    ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?=$this->session->flashdata('msg')?>
              </div>             
    <?php } ?>
    
    <?php

          if(!empty($this->session->flashdata('usernameerrormsg'))){

    ?>
    <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <?=$this->session->flashdata('usernameerrormsg')?>
              </div>
  
    <?php } ?>
        <div class="box box-warning">
            <div class="box-header customer">
                <h3 class="box-title">All Users</h3>

                <a class="add pull-right" href="<?=site_url('admin/users/addadminusers')?>"><button type="button" class="btn bg-navy margin addbtn">Add New</button></a>

            </div><!-- /.box-header -->



            <div class="box-body">
                <table id="adminuserstable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="desktoptab">Name</th>
                            <th class="desktoptab">Email</th>
                            <th class="desktoptab">Phone</th>
                            <th class="desktoptab">User Name</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php foreach ($admin_users as $data): ?>
                        <tr>
                            <td><?php echo $data['name']; ?></td>


                            <td class="miframe"><?php echo $data['email']; ?></td>
                             <td class="miframe"><?php echo $data['phone']; ?></td>
                            <td class="miframe"><?php echo $data['user_name']; ?></td>

                            <td>
   <div class="btn-group">
         <a href="<?=site_url('admin/users/editadminusers/'.$data['id'])?>"><button type="button" class="btn btn-warning firstbtngroup">Edit</button></a>
          <a data-toggle="modal" data-target="#myModal_<?php echo $data['id']; ?>" href="javascript:;"><button type="button" class="btn btn-danger lastbtngroup">Delete</button></a>
    </div>
                          


                                <div class="modal fade" id="myModal_<?php echo $data['id']; ?>" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title color-black">Delete User</h4>
                                            </div>
                                            <div class="modal-body color-black">
                                                <p>Are you sure you want to delete.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="<?php echo site_url('admin/Users/deleteadminuser/'.$data['id'])?>" type="button" class="btn btn-info">Yes</a>
                                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
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