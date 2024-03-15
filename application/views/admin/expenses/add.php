<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
 
    
    <?php if(validation_errors()){ ?>
    <section class="msg">
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Errors!</strong><br /><?php echo validation_errors(); ?>
        </div>   
    </section> 

    <?php } ?>

    <?php if($this->session->flashdata('error') && $this->session->flashdata('error')!=""){ ?>
        <section class="msg">
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Errors!</strong><br /><?php echo $this->session->flashdata('error'); ?>
            </div>
        </section>
    <?php }?>



    <!-- Main content -->
    <section class="content">
    <div class="box-header customer">
                <h3 class="box-title">New Package</h3>
                
            </div>
        <div class="row">
            <form role="form" action="<?=site_url('admin/packages/add')?>" method="post" enctype="multipart/form-data">
                <!-- right column -->
                <div class="col-md-12"><div class="box box-warning"></div></div>

                <div class="col-md-6">
                    <div class="form-group">
                    	<label for="f_name">Package Name</label>
                        <input type="text" class="form-control"  value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>"  id="name" name="name" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Admission Fees</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['admission_fees'])){echo $_POST['admission_fees'];} ?>"  id="admission_fees" name="admission_fees" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Fees</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['fees'])){echo $_POST['fees'];} ?>"  id="fees" name="fees" placeholder="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Members</label>
                        <input type="text"  class="form-control" value="<?php if(isset($_POST['members'])){echo $_POST['members'];} ?>"  id="members" name="members" placeholder="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="f_name">Duration</label>
                        <select class="" name="duration">
                            <option value="">Select Duration</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                </div>

     
                <div class="col-md-12">
                    <p class="alertp">* All asterik fields are required.</p>
                    <button type="submit" class="btn btn-primary btn-block btn-flat submit">SUBMIT</button>
                </div><!-- /.col -->

            </form>
        </div>   <!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
    var randomid = Math.floor(Math.random() * (999 - 000 + 1)) + 000;
    document.getElementById("id").value = 'Customer # '+randomid;
    document.getElementById("customer_id").value = randomid;

</script>