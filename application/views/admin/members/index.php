<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>

<div class="content-wrapper">

   
    <?php  if(!empty($this->session->flashdata('insertedrecord'))){
        if(isset($gym_detail['sms_counter_limit']) && $gym_detail['sms_counter_limit']>0){
        $record=$this->session->flashdata('insertedrecord');
        if(isset($record[0]['packagedetail']) && !empty($record[0]['packagedetail'])){
            $record[0]['fees']=$record[0]['packagedetail'][0]['fees'];
        }

        ?>
        <script>
            $( document ).ready(function() {
                
                
                var gymid=<?php echo $gym_detail['id']; ?>;
            var baseurl="<?php echo $baseUrl; ?>";
            
            var url=baseurl+"admin/members/decryment_gym_sms/";
            $.ajax({
                url: url,
                type: 'POST',
                data: { gymid: gymid} ,

                success: function(data){

                    console.log(data);
                },
                error: function(){
                    //	alert('error');

                }
            });
                
                
                    var membername='<?php echo $record[0]['name']; ?>';
                    var memberphone='<?php echo $record[0]['phone']; ?>';
                    var gymname='<?php echo $_SESSION['username']; ?>';
                    var gymaddress='<?php echo $_SESSION['address']; ?>';
                    var gymphone='<?php echo $_SESSION["phone"]; ?>';
                    var memberid='<?php echo $record[0]['id']; ?>';
                    var memberfees='<?php echo $record[0]['fees']; ?>';
                    var currencyunit='<?php echo $this->session->userdata['currency_symbol']; ?>';
                    //var memberphone="923024979258";
                    var message="Greetings, "+membername+" \n\nThank you for joining "+gymname+". Your membership details: \n\nMember Id: "+memberid+"\nFee: "+currencyunit+memberfees+"\n\n"+gymname+"\n"+gymphone;

                    var msg=encodeURI(message);
               
                    var url="http://api.bizsms.pk/api-send-branded-sms.aspx?username=abaskatech@bizsms.pk&pass=ab3sth99&text="+message+"&masking=SMS Alert&destinationnum="+memberphone+"&language=English";
                
                    var url=encodeURI(url);
               
                console.log(url);
                $.ajax({
                        url: url,
                        type: 'POST',
                        success: function(data){
                            console.log(data);
                        },
                        error: function(){
                        }
                    });
            });
        </script>
    <?php
    }  } ?>
         
    

    

    <?php if(isset($_GET['status']) && $_GET['status']!=""){$filtertype=$_GET['status'];} else{$filtertype="all";}?>
    
    
    
    
    
    
    
    
    
    
    
    <section class="content-header">
      <h1>
        Members
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $baseUrl; ?>admin/members">Members</a></li>
        <li class="active">All Members</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
           <?php 
               if(!empty($this->session->flashdata('error_msg'))){

    ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <?=$this->session->flashdata('error_msg')?>
              </div>
 
    <?php } ?>  
             <?php
          
          if(!empty($this->session->flashdata('msg'))){
    
    ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?=$this->session->flashdata('msg')?>
              </div>             
    <?php } ?>
            

            
            
            
          <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title">All Members</h3>
                <a href="<?=site_url('admin/members/add')?>"><button type="button" class="btn bg-navy margin addbtn">Add New</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="memberfilterwrapper">
                  
                <select id="typechanger" class="typechanger form-control select2">
                    <option <?php if(isset($filtertype) && $filtertype=="all"){echo "selected";}?> value="<?php echo site_url('admin/members?status=all')?>">All</option>
                    <option <?php if(isset($filtertype) && $filtertype=="paid"){echo "selected";}?> value="<?php echo site_url('admin/members?status=paid')?>">Paid Fees</option>
                    <option <?php if(isset($filtertype) && $filtertype=="pending"){echo "selected";}?> value="<?php echo site_url('admin/members?status=pending')?>">Pending Fees</option>
                </select>
                <form method="post" action="" class="customformidfilter">
                    <input class="form-control" placeholder="Search By Id" type="text" name="id" id="idseacrh" value="<?php if(isset($_POST['id'])){ echo $_POST['id']; } ?>">
                    <button class="btn btn-info" type="submit">Submit</button>
                </form>
                </div>
                
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="">Id</th>
                  <?php if($this->session->userdata['referncenumber_status']==true){ ?><th class="">Ref#ID</th><?php } ?>
                    <th class=""></th>
                    <th class="">Name</th>
          <?php if($this->session->userdata['show_phone']==1){ ?><th class="">Phone</th><?php } ?>
                    <th class="">Gender</th>
                    <?php if($this->session->userdata['show_fees']==1){ ?><th class="desktoptab">Fees</th><?php } ?>
                    <th class="">Fees Date</th>
                    <th class="">Action</th>
                </tr>
                </thead>
                
                    <tbody>
                        <?php //echo "<pre>"; var_dump($members); exit; //echo "<pre>"; var_dump($patients); exit;
                        foreach ($members as $member):
                           ?>

                                <tr>
                                    <td><?php echo $member['id']; ?></td>
                                    <?php if($this->session->userdata['referncenumber_status']==true){ if($member['refrence_no']==''){ ?>
                                    <td>N/A</td>
                                    <?php }else{ ?>
                                    <td><?php echo $member['refrence_no']; ?></td>
                                    <?php }} ?>
                                    <td class="memimg"><div class="memimg1" style="background-image:url(<?php if(isset($member['image']) && $member['image']!=''){echo site_url('uploads/thumb/'.$member['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>)"></div></td>
                                    <td class="activedivname"><?php if($member['status']==1){ ?><div class="activespan"></div><?php }else{ ?><div class="activespan deactivespan"></div><?php } ?><a href="<?=site_url('admin/members/view/'.$member['id'].'')?>" ><?php echo $member['name']; ?></a></td>
                                    <!--<td><?php echo $member['email']; ?></td>-->
                                    <?php if($this->session->userdata['show_phone']==1){ ?><td><?php echo $member['phone']; ?></td><?php } ?>
                                    <td><?php if(isset($member['gender']) && $member['gender']!=""){echo $member['gender'];} else{echo "N/A";} ?></td>
                                    <!--<td><?php echo $member['cnic']; ?></td>
                            <td><?php echo $member['address']; ?></td>-->
                                    <?php if($this->session->userdata['show_fees']==1){ ?>
                                    <?php if(isset($member['packagedetail']) && !empty($member['packagedetail'])){
                                    $totalfees=calculatefees($member['packagedetail']['fees'],$member['trainer_id'],$member['training_fees'],$member['commission_percentage']);
                                    ?>
                                    <?php } else{
                                    $totalfees=calculatefees($member['fees'],$member['trainer_id'],$member['training_fees'],$member['commission_percentage']);
                                    ?>
                                    <?php } } ?>
                                    <td><?php echo $this->session->userdata['currency_symbol']."".$totalfees; ?></td>
                                    
                                    <td><?php echo date("d-M-y",$member['fee_date']); ?></td>
                                    <td>
                                        
                                        <div class="margin">
                <div class="btn-group">
                  <button type="button" class="btn btn-info">Action</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu customactionmenuitems" role="menu">
                   <li><a href="<?=site_url('admin/members/edit/'.$member['id'].'')?>">Edit</a></li>
                    <li><a data-toggle="modal" data-target="#myModal_<?php echo $member['id']; ?>" href="javascript:;">Delete</a></li>
                    <li><a href="<?=site_url('admin/members/view/'.$member['id'].'')?>" >Detail</a></li>
              <li><a href="<?=site_url('admin/members/viewattendence/'.$member['id'].'')?>" >View Attendence</a></li>
              <li><a href="<?=site_url('admin/members/bodycomposition/'.$member['id'].'')?>" >Body Composition & Fitness</a></li>
                  </ul>
                                            </div></div>
                                        
                                    </td>






                                    <div class="modal fade" id="myModal_<?php echo $member['id']; ?>" role="dialog">
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
                                                    <a href="<?php echo site_url('admin/members/delete/'.$member['id'])?>" type="button" class="btn btn-info color-black">Yes</a>
                                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                            <!-- END Modal content-->

                                        </div>
                                    </div>


                                </tr>

                        <?php endforeach; ?>

                    </tbody>
                <tfoot>
                <tr>
                   <th class="">Id</th>
                    <?php if($this->session->userdata['referncenumber_status']==true){ ?><th class="">Ref#ID</th><?php } ?>
                    <th class=""></th>
                    <th class="">Name</th>
                                    <?php if($this->session->userdata['show_phone']==1){ ?><th class="">Phone</th><?php } ?>
                    <th class="">Gender</th>
                    <?php if($this->session->userdata['show_fees']==1){ ?><th class="desktoptab">Fees</th><?php } ?>
                    <th class="">Fees Date</th>
                    <th class="">Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        </div>
    </section>
</div>
    
    

<script>
    $( document ).ready(function() {
        $('#typechanger').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });
</script>