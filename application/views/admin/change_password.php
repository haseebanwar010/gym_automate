 <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header bread">
          
          <ol class="breadcrumb">
            <li><a href="<?=site_url()?>"> Home</a></li>
            <li class="active">Update Password</li>
          </ol>
        </section>
        <section class="content-header">
          <h1>
            Update Password          
          </h1>
          <small>Update your Password</small>
        </section>
        
        <?php if(validation_errors()){ ?>
        	<section class="msg">
                <div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Errors!</strong><br /><?php echo validation_errors(); ?>
                </div>   
            </section> 
        	
        <?php } ?>
        <?php if(isset($msg)){ ?>
        	<section class="msg">
                <div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Errors!</strong><br /><?php echo $msg; ?>
                </div>   
            </section> 
        	
        <?php } ?>
        
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <form role="form" action="<?php echo site_url('auth/change_password')?>" method="post" enctype="multipart/form-data">
            <?php $user = $this->session->get_userdata(); ?>
            <input type="hidden" id="staff_id" name="staff_id" value="<?php echo $user['userid']?>">
            <!-- right column -->
            <div class="col-md-12"><div class="box box-warning"></div></div>
               <div class="col-md-12">   
               <div class="row">      
              <div class="col-md-6">
            	<div class="form-group">
                   <input type="password" class="form-control"  id="old_password" name="old_password" placeholder="Old Password" value="">
                </div>
             </div>
             </div>
             <div class="row">   
             <div class="col-md-6">
            	<div class="form-group">
                   <input type="password" class="form-control"  id="new_password" name="new_password" placeholder="New Password" value="">
                </div>
             </div>
             </div>
             <div class="row">   
             <div class="col-md-6">
            	<div class="form-group">
                   <input type="password" class="form-control"  id="confirm_password" name="confirm_password" placeholder="Confirm Password" value="">
                </div>
             </div>
             </div>
             </div>
            <div class="col-md-6">
            
              <button type="submit" class="btn btn-primary btn-block btn-flat submit submit_btns1">UPDATE</button>
            </div><!-- /.col -->
            
            </form>
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
       