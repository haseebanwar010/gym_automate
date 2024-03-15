<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
 
    
   <?php if(validation_errors()){ ?>
   <section class="content alertcontent">    
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <?php echo validation_errors(); ?>
            </div>
        </section>

    <?php } ?>

    <?php if($this->session->flashdata('error') && $this->session->flashdata('error')!=""){ ?>
       
    <section class="content alertcontent">    
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Errors!</h4>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        </section>
    <?php }?>
<section class="content-header">
      <h1>
        Add Currency
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>superadmin/currencies">Currencies</a></li>
        <li class="active">Add Currency</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-warning">
    <div class="box-header with-border">
                <h3 class="box-title">New Currency</h3>
                
            </div>
        <div class="box-body">
           <form role="form" action="<?=site_url('superadmin/currencies/add')?>" method="post" enctype="multipart/form-data">
                <!-- right column -->
                <div class="col-md-12"><div class=""></div></div>
                    
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Currency Name</label>
                        <input type="text" class="form-control"  value="<?php if(isset($_POST['currency_name'])){echo $_POST['currency_name'];} ?>"  id="currency_name" name="currency_name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Currency Symbol</label>
                        <input type="text" class="form-control"  value="<?php if(isset($_POST['currency_symbol'])){echo $_POST['currency_symbol'];} ?>"  id="currency_symbol" name="currency_symbol" placeholder="">
                    </div>
                </div>

<div class="col-lg-12">
                    <div class="form-group">
                        <button class="btn bg-navy margin submitbtn" type="submit">Submit</button>
                    </div>
                </div>

            </form>
        </div>   
        </div>
    </section><!-- /.content -->
</div>

