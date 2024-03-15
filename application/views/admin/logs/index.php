<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>

<div class="content-wrapper">
   
    
    
    
    <section class="content-header">
      <h1>
        Logs
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/logs/alllogs">Logs</a></li>
        <li class="active">All Logs</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
      
            

            
            
            
          <div class="box box-warning">
            <div class="box-body">
            <div class="box-header logheader">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">Logs</h3>
            </div>
                <div class="logfilter">
                    <form method="post" action="" autocomplete="off" class="customformfilter2">
                        <label>Date</label>
                        <input  type="text"  class="form-control datepicker" value="<?php if(isset($_POST['date']) && !empty($_POST['date'])){echo date('m/d/Y',strtotime($_POST['date']));} ?>"  id="" name="date" placeholder="">
                        <button class="btn bg-navy margin submitbtn attformsumb" type="submit">Submit</button>
                    </form>
                </div>   
            <div class="box-body logbody">
              <ul class="todo-list">
                  <?php if(empty($logs)){ ?>
                  <p class="text-red textcenter">No record found.</p>
                  <?php }else{ foreach($logs as $log){ ?>
                <li><span class="text"><?php echo $log; ?></span></li>
                  <?php }} ?>
              </ul>
            </div>
            </div>
          </div>
        </div>
        </div>
    </section>
</div>
    