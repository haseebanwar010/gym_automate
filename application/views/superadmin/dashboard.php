<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
 <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        
        
    <?php if($this->session->flashdata('msg')!=''){ ?>
    <section class="msg">
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('msg');?>
        </div>   
    </section>                 
    <?php } ?>
        
        <!-- Main content -->
        <section class="content">
          
          
                <div class="box-header">
                  <h3 class="box-title">Dashboard</h3>
                </div><!-- /.box-header -->
                
                <?php $user = $this->session->get_userdata();
				?>
				
				
                <div class="row">
            
            <!-- right column -->
            <div class="col-md-12"><div class="box box-warning"></div></div>
                
              </div>
                
                
            
          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->