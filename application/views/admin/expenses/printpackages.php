
<link rel="stylesheet" href="<?php echo $baseUrl?>assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $baseUrl?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<link rel="stylesheet" href="<?php echo $baseUrl?>assets/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="<?php echo $baseUrl?>assets/css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo $baseUrl?>assets/dist/css/style.css">
<style>
    .content-wrapper, .right-side{
        background-color: #fff !important;
    }
    #example1 tr td{
        padding: 5px 10px !important;
        /*border: 1px solid !important;*/

    }
    #example1 tr th{
        padding: 5px 10px !important;
        /*border: 1px solid !important;*/
    }


    </style>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->

       
    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header customer">
                <h3 class="box-title">Packages</h3>
                 

                
            </div>

          
  
         
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="desktoptab">Name</th>

                            <th class="desktoptab">Admission Fees</th>

                            <th class="desktoptab">Members</th>
                            <th class="desktoptab">Duration</th>
                            <th class="desktoptab">Fees</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php //echo "<pre>"; var_dump($gyms); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($packages as $package): ?>
                        <tr>  
                            <td><?php echo $package['name']; ?></td>
                            <td><?php echo $this->session->userdata['currency_symbol']."".$package['admission_fees']; ?></td>
                            <td><?php echo $package['members']; ?></td>
                            <td><?php echo $package['duration']." Month"; ?></td>
                            <td><?php echo $this->session->userdata['currency_symbol']."".$package['fees']; ?></td>

                        </tr> 
                                          
<?php endforeach; ?> 

                    </tbody>

                </table>
            </div><!-- /.box-body -->
        </div>


    </section><!-- /.content -->
</div>