<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<script>
    function runScript(e) {
    if (e.keyCode == 13) {
        updatesearchfilter();
    }
}
    $(document).ready(function(){
        
        $('#searchmembersubmit').click(function(){
            updatesearchfilter();
        });
        
        
        
    });
    function updatesearchfilter(){
            var searchtype=$('#searchtype').val();
            var searchkey=$('#searchkey').val();
            if(searchtype!="" && searchkey!=""){
                var baseurl="<?php echo $baseUrl; ?>";
                var url=baseurl+"admin/members/search/";
                $.ajax({
				url: url,
				type: 'POST',
				data: { searchtype: searchtype, searchkey : searchkey} ,

				success: function(data){
                console.log(data);
                    if(data!=null && data!=''){
                        $('#searchtbody').html(data);
                        $( "#tablesearchshowhide" ).show(300);
                        //
                    }
                    else{
                        $('#searchtbody').html(data);
                        $( "#tablesearchshowhide" ).hide(300);
                    }
                    
				},
				error: function(error){
                    console.log(error);
					alert('error');

				}
			});
            }
        }
    
</script>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $baseUrl; ?>admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

<?php if($this->session->userdata('parent_gym')==1 || isset($_SESSION['authorization']['dashboard_access']) && $_SESSION['authorization']['dashboard_access']==1){ ?>
      

    <section class="content">
        
        <div class="alert alert-success alert-dismissible attendencemessage">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>Attendence Added Successfully.
            </div>
      
      <?php if($this->session->flashdata('msg')!=''){ ?>
        <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4><?php echo $this->session->flashdata('msg');?>
            </div>             
    <?php } ?>
      <!-- Small boxes (Stat box) -->
      <div class="row">
          <div class="col-lg-9">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $totalmembers; ?></h3>

              <p>Total Registered Members</p>
            </div>
            <div class="icon">
              <i class="fa fa-registered" aria-hidden="true"></i>
            </div>
            <a href="registered" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $totalactivemembers; ?></h3>

              <p>Total Active Members</p>
            </div>
            <div class="icon">
             <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <a href="active" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $totalinactivemembers; ?></h3>

              <p>Total Inactive Members</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-secret" aria-hidden="true"></i>
            </div>
            <a href="inactive" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $upcomingfeecount; ?></h3>

              <p>Upcoming Fees</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-secret" aria-hidden="true"></i>
            </div>
            <a href="upcoming" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          
          <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $totalactivemembers-$pendingfeesthismonth; ?></h3>

              <p>Paid Fees</p>
            </div>
            <div class="icon">
              <i class="fa fa-money" aria-hidden="true"></i>
            </div>
            <a href="paidfees" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          
          <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $pendingfeesthismonth; ?></h3>

              <p>Pending Fees</p>
            </div>
            <div class="icon">
               <i class="fa fa-hourglass-half" aria-hidden="true"></i>
            </div>
            <a href="pendingfees" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
              
              
              
              
          </div>
          <div class="col-lg-3">
              <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
              <div class="info-box-content">
              <a style="color:#fff;" href="<?php echo $baseUrl; ?>present"><span class="info-box-text">Total Present Today</span>
                  <span class="info-box-number"><?php echo $total_todays_entrances; ?></span></a>
<?php if($totalactivemembers==0){ $perc=0; }else{ $perc=$total_todays_entrances/$totalactivemembers; $perc=$perc*100; } ?>
              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    <?php echo number_format((float)$perc, 2, '.', '');; ?>% Members present today.
                  </span>
            </div>
              </div>
              
<!--
        <div class="col-md-12 col-sm-12 col-xs-12 customwidgeta">
          <a href="<?php echo site_url('present'); ?>"><div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Present Today</span>
              <span class="info-box-number"><?php echo $total_todays_entrances; ?></span>
            </div>
              
              </div></a>
        </div>
-->
              
              <div class="box box-warning">
            <div class="box-header with-border headlabels">
                <p>Total Active Members: <strong><?php echo $totalactivemembers; ?></strong></p>
                <p>Total Present Today: <strong><?php echo $total_todays_entrances; ?></strong></p>
<!--              <h3 class="box-title">Attendence Chart</h3>-->

              <div class="box-tools pull-right">
              </div>
            </div>
            <div class="box-body">
                <div class="custompiechart">
                    <canvas id="pieChart" style="height:100px"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

              
              
          </div>
          
            <div class="col-md-12 custompadding_align">
          <div class="box box-danger direct-chat direct-chat-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Search Member</h3>
            </div>
            <div class="box-footer">
                <div class="col-md-9">
<!--              <form action="<?php echo $baseUrl; ?>admin/members/search" method="post">-->
                <div class="input-group">
                  <input type="text" name="searchkey" id="searchkey" placeholder="Search Member ..." class="form-control" onkeypress="return runScript(event)">
                      <span class="input-group-btn">
                        <button type="button" id="searchmembersubmit" class="btn btn-danger btn-flat">Submit</button>
                      </span>
                </div>
<!--              </form>-->
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                <select id="searchtype" class="form-control select2" style="width: 100%;">
<!--                  <option selected="selected" value="">Please select search type</option>-->
                    <option selected="selected" value="name" >Name</option>
                    <option value="id">ID</option>
                    <option value="phone">Phone</option>
                    <option value="refrenceno">Refrence Number</option>
                </select>
              </div>
                </div>
            </div>
              <div class="col-md-12">
                  
                  <table id="tablesearchshowhide" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="">Id</th>
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Gender</th>
                    <th class="desktoptab">Fees</th>
                    <th class="">Fees Date</th>
                    <th class="">Action</th>
                </tr>
                </thead>
                
                    <tbody id="searchtbody">
                    </tbody>
                <tfoot>
                <tr>
                   <th class="">Id</th>
                    <th class="">Name</th>
                    <th class="">Phone</th>
                    <th class="">Gender</th>
                    <th class="desktoptab">Fees</th>
                    <th class="">Fees Date</th>
                    <th class="">Action</th>
                </tr>
                </tfoot>
              </table>
              </div>
              <div class="clear"></div>
          </div>
        </div> 
        <!-- ./col -->
      </div>
        
       
      
        
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title">Upcoming Fee</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <?php if($this->session->userdata['show_phone']==1){ ?><th>Phone</th><?php } ?>
                  <th>Date</th>
                    <?php if($this->session->userdata['show_fees']==1){ ?><th>Fee Amount</th><?php } ?>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php

$tablename="tbl_member_".$_SESSION['userid'];
foreach ($upcomingfee as $upcomfee):
if(isset($gym_detail['sms_counter_limit']) && $gym_detail['sms_counter_limit']>sizeof($upcomingfee) && isset($upcomfee['remindersms_status']) && $upcomfee['remindersms_status']==0){
	
    $feedate=$upcomfee['fee_date'];
                            $feetime=date('Y-M-d',$feedate);
    ?>
                    
    <script>
        $( document ).ready(function() {
             var gymid="<?php echo $gym_detail['id']; ?>";
             var memberid="<?php echo $upcomfee['id']; ?>";
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
			
			var url=baseurl+"admin/members/updatereminderstatus/";
            $.ajax({
                url: url,
                type: 'POST',
                data: { memberid:memberid, tablename:"tbl_member_"+gymid } ,

                success: function(data){

                    console.log(data);
                },
                error: function(){
                    //	alert('error');

                }
            });

//            var fees='<?php if(isset($upcomfee['packagedetail']) && !empty($upcomfee['packagedetail'])){echo $upcomfee['packagedetail']['fees']; }else{echo $upcomfee['fees'];} ?>';
            var fees='<?php if(isset($upcomfee['packagedetail']) && !empty($upcomfee['packagedetail'])){
                                    $totalfees=calculatefees($upcomfee['packagedetail']['fees'],$upcomfee['trainer_id'],$upcomfee['training_fees'],$upcomfee['commission_percentage']);
                                    ?>
                                    <?php } else{
                                    $totalfees=calculatefees($upcomfee['fees'],$upcomfee['trainer_id'],$upcomfee['training_fees'],$upcomfee['commission_percentage']);
                                    ?>
                                    <?php } echo $totalfees; ?>';
            var feesdate='<?php echo $feetime; ?>';
            var gymname='<?php echo $_SESSION["username"]; ?>';
            var gymphone='<?php echo $_SESSION["phone"]; ?>';
            var gymaddress='<?php echo $_SESSION['address']; ?>';
            var membername='<?php echo $upcomfee['name']; ?>';
            var memberphone='<?php echo $upcomfee['phone']; ?>';
            var currencyunit='<?php echo $this->session->userdata['currency_symbol']; ?>';
            //var memberphone="923024979258";




            var message="Dear "+membername+", \n\nYour Membership fee is due. Following are the details:\nDue date: "+feesdate+"\nMembership Fee: "+currencyunit+fees+"\n\n"+gymname+"\n"+gymphone;
            var msg=encodeURI(message);
            var url="http://api.bizsms.pk/api-send-branded-sms.aspx?username=abaskatech@bizsms.pk&pass=ab3sth99&text="+message+"&masking=SMS Alert&destinationnum="+memberphone+"&language=English";
            var url=encodeURI(url);
            $.ajax({
                url: url,
                type: 'POST',
                success: function(data){
                   // alert('Message has been sent succesfully');
                    console.log(data);
                },
                error: function(){
                    //alert('error');
                   // alert('Message has been sent succesfully');
                }
            });


        });

    </script>
<?php } ?>



                        <tr>
                            <?php $feedate=$upcomfee['fee_date'];
                            $feetime=date('Y-M-d',$feedate); ?>
                            <td class="memimg"><div class="memimg1" style="background-image:url(<?php if(isset($member['image']) && $member['image']!=''){echo site_url('uploads/thumb/'.$member['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>)"></div></td>
                            <td class="activedivname"><?php if($upcomfee['status']==1){ ?><div class="activespan"></div><?php }else{ ?><div class="activespan deactivespan"></div><?php } ?><a href="<?=site_url('admin/members/view/'.$upcomfee['id'].'')?>"><?php echo $upcomfee['name']; ?></a>  </td>
      <?php if($this->session->userdata['show_phone']==1){ ?><td><?php echo $upcomfee['phone']; ?> </td><?php } ?>
                            <td><?php echo $feetime; ?></td>
<?php if($this->session->userdata['show_fees']==1){ ?>
                            <?php if(isset($upcomfee['packagedetail']) && !empty($upcomfee['packagedetail'])){
                                    $totalfees=calculatefees($upcomfee['packagedetail']['fees'],$upcomfee['trainer_id'],$upcomfee['training_fees'],$upcomfee['commission_percentage']);
                                    ?>
                                    <?php } else{
                                    $totalfees=calculatefees($upcomfee['fees'],$upcomfee['trainer_id'],$upcomfee['training_fees'],$upcomfee['commission_percentage']);
                                    ?>
                                    <?php }  ?>
                            <td><?php echo $this->session->userdata['currency_symbol']."".$totalfees; ?> </td>
<?php } ?>
                            <td class="reminderpaysection">
                                
                                 <div class="">
                <div class="btn-group">
                  <button type="button" class="btn btn-info">Action</button>
                  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu customactionmenuitems" role="menu">
                   <li><a href="javascript:;" data-toggle="modal" class="fee_btn_s1" data-target="#myModal_<?php echo $upcomfee['id']; ?>">Pay Fee</a></li>
                    <?php if(isset($gym_detail['sms_counter_limit']) && $gym_detail['sms_counter_limit']>0){ ?>
                      <li><a id="sendreminder" data-tablename="tbl_member_<?php echo $_SESSION['userid']; ?>" data-memberphone="<?php echo $upcomfee['phone']; ?>" data-memberid="<?php echo $upcomfee['id']; ?>" data-membername="<?php if(isset($upcomfee['name']) && $upcomfee['name']!=""){echo $upcomfee['name'];} else{echo "N/A";} ?>" data-gymname="<?php if(isset($_SESSION['username']) && !empty($_SESSION['username'])){echo $_SESSION['username'];} else{echo "N/A";}?>" data-feesdate="<?php if(isset($upcomfee['fee_date']) && $upcomfee['fee_date']!=""){echo date("d-M-y",$upcomfee['fee_date']);} else{echo "N/A";} ?>" data-fees="<?php if(isset($upcomfee['package']) && $upcomfee['package']!="custom"){echo $upcomfee['packagedetail']['fees']; } else{echo $upcomfee['fees'];}?>">Reminder</a></li>
                      <?php } ?>
                      <li><a href="<?=site_url('admin/members/bodycomposition/'.$upcomfee['id'].'')?>" >Body Composition & Fitness</a></li>
                  </ul>
                                            </div></div>
                                
                                
                                
                            </td>
<div class="modal fade" id="myModal_<?php echo $upcomfee['id']; ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pay Fee</h4>
              </div>
              <div class="modal-body overflowmodalbody">
                <form method="post" action="<?=site_url('admin/dashboard/payfee')?>">
                                       
                                        <div class="modal-body color-black popupfeeform">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="f_name">Date</label>
                                                    <?php $cdate = date('m/d/Y');  ?>
                                                  <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" value="<?php echo $cdate; ?>" class="form-control pull-right datepicker" name="payment_date">
                </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <label for="f_name">Fee</label>
                                                 <div class="input-group form-group">
                <span class="input-group-addon"><?php echo $this->session->userdata['currency_symbol']; ?> </span>
                                                     <input  type="text"  class="form-control" value="<?php echo $totalfees; ?>"  id="fees" name="fees" placeholder="">
                                                     <input  type="hidden"  class="form-control" value="<?php echo $upcomfee['id']; ?>"  id="id" name="id" placeholder="">
                                                     <input  type="hidden"  class="form-control" value="<?php echo $upcomfee['name']; ?>"  id="name" name="name" placeholder="">
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
                                            <div class="col-md-12">
                                             <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                            <button class="btn btn-info" type="submit">Submit</button>
                                            </div>
                                        </div>
                                            </form>
              </div>
             
            </div>
          </div>
        </div>


                           
                        </tr>
<?php endforeach;?>
               
                </tbody>
                <tfoot>
                <tr>
                  <th></th>
                  <th>Name</th>
                    <?php if($this->session->userdata['show_phone']==1){ ?><th>Phone</th><?php } ?>
                  <th>Date</th>
                    <?php if($this->session->userdata['show_fees']==1){ ?><th>Fee Amount</th><?php } ?>
                    <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
          <!--<div class="col-xs-6">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Active Members</h3>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-striped example1">
                <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    
                    
                    <?php foreach ($activemembers as $member): ?>
                        <tr style="background">
                            <?php $feedate=$member['fee_date'];
                            $feetime=date('Y-M-d',$feedate); ?>
                            <td class="memimg" >
                                <div class="memimg1" style="background-image:url(<?php if(isset($member['image']) && $member['image']!=''){echo site_url('uploads/thumb/'.$member['image']);} else{echo site_url('frontend/images/noimage.jpg');} ?>)"></div>

                            </td>
                            <td><a href="<?=site_url('admin/members/view/'.$member['id'].'')?>"><?php echo $member['name']; ?></a> </td>
                            <td><?php echo $member['phone']; ?> </td>
                            <td><?php echo $feetime; ?></td>

                            <td>

                                <button type="button" class="btn btn-block btn-info" data-toggle="modal" class="fee_btn_s1 fee_btn_s3" data-target="#myModalattendence_<?php echo $member['id']; ?>" href="javascript:;">Attendence</button>
                                
                            </td>


                            
                            <div class="modal fade" id="myModalattendence_<?php echo $member['id']; ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Attendence</h4>
              </div>
              <div class="modal-body">
                <form method="post" action="<?=site_url('admin/dashboard/addattendence')?>">
                                       
                                        <div class="modal-body color-black popupfeeform">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="f_name">Date</label>
                                                    <?php $cdate = date('m/d/Y');  ?>
                                                    <input  type="hidden"  class="form-control" value="<?php echo $member['id']; ?>"  id="member_id" name="member_id" placeholder="">
                                                  <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" value="<?php echo $cdate; ?>" class="form-control pull-right datepicker" name="date">
                </div>
                                                </div>
                                            </div>
                                            <div class="bootstrap-timepicker col-md-12">
                <div class="form-group">
                  <label>Time In:</label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="timein">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                </div>
              </div>
                                            <div class="bootstrap-timepicker col-md-12">
                <div class="form-group">
                  <label>Time Out:</label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="timeout">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                </div>
              </div>
                                            

                                        </div>
                                        <div class="modal-footer col-md-12">
                                            <div class="col-md-12">
                                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                             <button type="submit" class="btn btn-info">Submit</button>
                                            </div>
                                        </div>
                                            </form>
              </div>
            
            </div>
          </div>
        </div>
                            
                            
                        </tr>
<?php  endforeach;?>
                    
                  </tbody>
                  <tfoot>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Date</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                </table>
              </div>
              </div>
          </div>-->
      </div>
        
      
    </section>




<?php } ?>
</div>



 <div class="modal fade" id="myrejoinModal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <form method="post" action="<?=site_url('admin/members/payrejoinfee')?>">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title color-black">Pay Fee</h4>
                                            </div>
                                            <div class="modal-body color-black popupfeeform">

                                                <div class="col-md-12">
                                                    
                                                    <div class="form-group">
                                                        <label for="f_name">Date</label>
                                                        
                                                        <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                                                        <input  type="text"  class="form-control datepicker" value=""  id="myrejoinModal_cdate" name="payment_date" placeholder="">
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                   
                                                    <label for="f_name">Fees</label>
                                                    <div class="form-group input-group">
                                                        <span class="input-group-addon"><?php echo $this->session->userdata['currency_symbol']; ?> </span>
                                                        <input  type="text"  class="form-control" value=""  id="myrejoinModal_fees" name="fees" placeholder="">
                                                        
                                                        <input  type="hidden"  class="form-control" value=""  id="myrejoinModal_id" name="id" placeholder="">
                                                        <input  type="hidden"  class="form-control" value=""  id="myrejoinModal_name" name="name" placeholder="">
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
                                                <div class="col-md-12">
                                                <button class="btn btn-info" type="submit">Submit</button>
                                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END Modal content-->

                                </div>
                            </div>

 <div class="modal fade" id="myinactivefeeModal" role="dialog">
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
                                                        <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                                                        <input  type="text"  class="form-control datepicker" value=""  id="myinactivefeeModal_cdate" name="payment_date" placeholder="">
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-12">
                                                   
                                                    <label for="f_name">Fees</label>
                                                    <div class="form-group input-group">
                                                        <span class="input-group-addon"><?php echo $this->session->userdata['currency_symbol']; ?> </span>
                                                        <input  type="text"  class="form-control" value=""  id="myinactivefeeModal_fees" name="fees" placeholder="">
                                                        
                                                        <input  type="hidden"  class="form-control" value=""  id="myinactivefeeModal_id" name="id" placeholder="">
                                                        <input  type="hidden"  class="form-control" value=""  id="myinactivefeeModal_name" name="name" placeholder="">
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
                                                <div class="col-md-12">
                                                    <button class="btn btn-info" type="submit">Submit</button>
                                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END Modal content-->

                                </div>
                            </div>
<div class="modal fade" id="myinactivedeleteModal" role="dialog">
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
                                                    <a id="deleteurl" href="" type="button" class="btn btn-info color-black">Yes</a>
                                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                            <!-- END Modal content-->

                                        </div>
                                    </div>
<script>
    $("#searchtbody").on('click', '.myrejoinclicker', function() {
            //myrejoinModal
            var cdate=$(this).data('cdate');
            var fees=$(this).data('fees');
            var memberid=$(this).data('memberid');
            var membername=$(this).data('membername');
        
            $('#myrejoinModal_cdate').val(cdate);
            $('#myrejoinModal_fees').val(fees);
            $('#myrejoinModal_id').val(memberid);
            $('#myrejoinModal_name').val(membername);
            $('#myrejoinModal').modal('show');
        });
    $("#searchtbody").on('click', '.myinactivefeeModalclicker', function() {
            //myrejoinModal
            var cdate=$(this).data('cdate');
            var fees=$(this).data('fees');
            var memberid=$(this).data('memberid');
            var membername=$(this).data('membername');
            $('#myinactivefeeModal_cdate').val(cdate);
            $('#myinactivefeeModal_fees').val(fees);
            $('#myinactivefeeModal_id').val(memberid);
            $('#myinactivefeeModal_name').val(membername);
            $('#myinactivefeeModal').modal('show');
        });
    $("#searchtbody").on('click', '.myinactivedeleteClicker', function() {
        var baseurl="<?php echo $baseUrl; ?>";
        var memberid=$(this).data('memberid');
        var hrefurl=baseurl+'admin/members/delete/'+memberid;
        $("#deleteurl").attr("href", hrefurl); 
        $('#myinactivedeleteModal').modal('show');
    });
</script>
<!-- page script -->
<script>
  $(function () {
    
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var totalactivemembers="<?php echo $totalactivemembers; ?>";
    var totalpresenttoday="<?php echo $total_todays_entrances; ?>";
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    var PieData        = [
      {
        value    : totalactivemembers,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'Total Active Members'
      },
      {
        value    : totalpresenttoday,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Total Present Today'
      }
    ]
    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  })
</script>
<script>
    
</script>