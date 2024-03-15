

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
    <section class="invoice">

        <div class="box">
            <div class="box-header customer">
                <h3 class="box-title">Patient Information</h3>
                 
                
                
            </div><!-- /.box-header -->
          
            <?php
            //var_dump($history);
            //exit;
            //$patientid;
            $patientdetail=getpatientbyid($patientid);
           
           ?>
 <div class="row ">
          <div class="col-xs-12">
            <table class="table table-striped ">
            	<tr>
                    <th> Name</th>
                    <td><?php echo $patientdetail[0]['name']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                     <td><?php echo $patientdetail[0]['email']; ?></td>
                </tr>
               
                <tr>
                    
                    <th>Phone Number</th>
                    <td><?php echo $patientdetail[0]['phone']; ?></td>
                </tr>
                
                <tr>
                    
                    <th>Address</th>
                    <td><?php echo $patientdetail[0]['address']; ?></td>
                </tr>
               
               
            </table>
            </div>
          </div>
        </div>
    </section>
            
            
            <section class="content">

        <div class="box"> 
          <div class="box-header customer historyboxheader">
                <h3 class="box-title">History</h3>
                 
                
                
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="desktoptab">Appointed To</th>
                            <th class="desktoptab">Type</th>
                            <th class="desktoptab">Date</th>
                            <th class="desktoptab">Status</th>
                           
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //var_dump($history);
                        //exit;
                        foreach ($history as $history): 
                       
                        $patientid=$history['patient_id'];
                        $doctorid=$history['doctor_id'];
                        $doctordetail=getdoctorbyid($doctorid);
                        /*echo $doctordetail[0]['first_name'];
                        var_dump($doctordetail);
                        exit;*/
                        
                        
                        if(isset($doctordetail) && $doctordetail!=null){
                            $dt = new DateTime($doctordetail[0]['created_date']);
$date = $dt->format('m-d-Y');
$time = $dt->format('H:i:s');
                        }
                        else{
                            $date="NA";
                        }
                        
                        
                        ?>
                        <tr>  
                            <?php  if(isset($doctordetail) && $doctordetail!=null){ ?>
                            <td><?php echo $doctordetail[0]['first_name']." ".$doctordetail[0]['last_name']; ?></td>
                            <td><?php echo $doctordetail[0]['acc_type']; ?></td>
                            <?php } else{ ?>
                            <td>NA</td>
                            <td>NA</td>
                            <?php } ?>
                            
                            <td><?php echo $date; ?></td>
                            <td class="<?php if($history['appointment_status']==0){echo "mdeactivated";} elseif($history['appointment_status']==1){echo "mactivated";} ?>">
                                <?php if($history['appointment_status']==0){echo "Deactivated";} elseif($history['appointment_status']==1){echo "Activated";} ?></td>
                            
                        </tr> 
                                          
<?php endforeach; ?> 

                    </tbody>

                </table>
            </div><!-- /.box-body -->
        </div>


    </section><!-- /.content -->
</div>