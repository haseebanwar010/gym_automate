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





            <div class="row maintabsrows">
                <a href="registered"><div class="col-md-3 col-sm-6 col-xs-6 mmaintabsingle">
                    <div class="panel panel-back noti-box">
                <span class="mtotal icon-box bg-color-brown set-icon">
                   <i class="fa fa-registered" aria-hidden="true"></i>

                </span>
                        <div class="text-box" >
                            <p class="main-text"><?php echo $totalmembers; ?></p>
                            <p class="text-muted">Total Registered Members</p>
                        </div>
                    </div>
                </div></a>
                <a href="active"> <div class="col-md-3 col-sm-6 col-xs-6 mmaintabsingle">
                    <div class="panel panel-back noti-box">
                <span class="mactive icon-box bg-color-brown set-icon">
                    <i class="fa fa-users" aria-hidden="true"></i>
                </span>
                        <div class="text-box" >
                            <p class="main-text"><?php echo $totalactivemembers; ?></p>
                            <p class="text-muted">Total Active Members</p>
                        </div>
                    </div>
                </div></a>
                <a href="inactive"> <div class="col-md-3 col-sm-6 col-xs-6 mmaintabsingle">
                    <div class="panel panel-back noti-box">
                <span class="mdanger icon-box bg-color-brown set-icon">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                </span>
                        <div class="text-box" >
                            <p class="main-text"><?php echo $totalinactivemembers; ?></p>
                            <p class="text-muted">Total Inactive Members</p>
                        </div>
                    </div>
                </div></a>

                <a href="upcoming"> <div class="col-md-3 col-sm-6 col-xs-6 mmaintabsingle">
                        <div class="panel panel-back noti-box">
                <span class="mupcoming icon-box bg-color-brown set-icon">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                </span>
                            <div class="text-box" >
                                <p class="main-text"><?php echo $upcomingfeecount; ?></p>
                                <p class="text-muted">Upcoming Fees</p>
                            </div>
                        </div>
                    </div></a>







                <a href="pastfees"> <div class="col-md-3 col-sm-6 col-xs-6 mmaintabsingle">
                        <div class="panel panel-back noti-box">
                <span class="mpast icon-box bg-color-brown set-icon">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                </span>
                            <div class="text-box" >
                                <p class="main-text"><?php echo $pastfeescount; ?></p>
                                <p class="text-muted">Past Date</p>
                            </div>
                        </div>
                    </div></a>





                <a href="paidfees"> <div class="col-md-3 col-sm-6 col-xs-6 mmaintabsingle">
                        <div class="panel panel-back noti-box">
                <span class="mpaidmem icon-box bg-color-brown set-icon">
                    <i class="fa fa-money" aria-hidden="true"></i>

                </span>
                            <div class="text-box" >
                                <p class="main-text"><?php echo $totalactivemembers-$pendingfeesthismonth; ?></p>
                                <p class="text-muted">Paid Fees</p>
                            </div>
                        </div>
                    </div></a>

                <a href="pendingfees"> <div class="col-md-3 col-sm-6 col-xs-6 mmaintabsingle">
                        <div class="panel panel-back noti-box">
                <span class="munpaidmem icon-box bg-color-brown set-icon">
                    <i class="fa fa-ban" aria-hidden="true"></i>

                </span>
                            <div class="text-box" >
                                <p class="main-text"><?php echo $pendingfeesthismonth; ?></p>
                                <p class="text-muted">Pending Fees</p>
                            </div>
                        </div>
                    </div></a>
                <!--<div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <i class="fa fa-envelope-o"></i>
                </span>
                        <div class="text-box" >
                            <p class="main-text">120 New</p>
                            <p class="text-muted">Messages</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-bars"></i>
                </span>
                        <div class="text-box" >
                            <p class="main-text">30 Tasks</p>
                            <p class="text-muted">Remaining</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-bell-o"></i>
                </span>
                        <div class="text-box" >
                            <p class="main-text">240 New</p>
                            <p class="text-muted">Notifications</p>
                        </div>
                    </div>
                </div>
-->
            </div>


<div class="wholewrapper">
            <div class="leftdivwrapper">

            <!-- title row -->
            <div class="box-header customer">
                <h3 class="box-title">Upcoming Fee</h3>

            </div>
            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Date</th>
                            <th>Fee Amount</th>
                            <th class="mcenter">Action</th>

                        </tr>
                        </thead>
                        <tbody>
<?php


$tablename="tbl_member_".$_SESSION['userid'];
foreach ($upcomingfee as $upcomfee):


if(isset($upcomfee['remindersms_status']) && $upcomfee['remindersms_status']==0){
    $feedate=$upcomfee['fee_date'];
                            $feetime=date('Y-M-d',$feedate);
    ?>


    <script>


        $( document ).ready(function() {



            var tablename='<?php echo $tablename; ?>';
            var memberid=<?php echo $upcomfee['id']; ?>;

            var url="http://localhost/Gym/members/updatereminderstatus/";
            $.ajax({
                url: url,
                type: 'POST',
                data: { tablename: tablename, memberid : memberid} ,

                success: function(data){

                    console.log(data);
                },
                error: function(){
                    //	alert('error');

                }
            });



            var fees='<?php if(isset($upcomfee['packagedetail']) && !empty($upcomfee['packagedetail'])){echo $upcomfee['packagedetail']['fees']; }else{echo $upcomfee['fees'];} ?>';
            var feesdate='<?php echo $feetime; ?>';
            var gymname='<?php echo $_SESSION["username"]; ?>';
            var membername='<?php echo $upcomfee['name']; ?>';
            var memberphone='<?php echo $upcomfee['phone']; ?>';
            //var memberphone="923024979258";




            var message="Dear "+membername+", \n\nThis is to remind you that your Membership fee is due. Following are the details:\nDue date: "+feesdate+"\nMembership Fee: Rs"+fees+"\n\n"+gymname;
            var msg=encodeURI(message);
            var url="http://api.bizsms.pk/api-send-branded-sms.aspx?username=d-sales-ay@bizsms.pk&pass=89demo9787&text="+message+"&masking=Demo&destinationnum="+memberphone+"&language=English";
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

                            <td><a href="<?=site_url('admin/members/view/'.$upcomfee['id'].'')?>"><?php echo $upcomfee['name']; ?></a> </td>
                            <td><?php echo $upcomfee['phone']; ?> </td>
                            <td><?php echo $feetime; ?></td>

<?php if(isset($upcomfee['packagedetail']) && !empty($upcomfee['packagedetail'])){
    ?>
    <td>Rs<?php echo $upcomfee['packagedetail']['fees']; ?> </td>
<?php }else{ ?>
                            <td>Rs<?php echo $upcomfee['fees']; ?> </td>
<?php } ?>
                            <td>
                                <a data-toggle="modal" class="fee_btn_s1" data-target="#myModal_<?php echo $upcomfee['id']; ?>" href="javascript:;">Pay Fee</a> 
                               <!-- <a data-toggle="modal" class="fee_btn_s2" data-target="#myModalreminder" href="javascript:;">Send Reminder</a>-->

                                <?php if(isset($upcomfee['sms']) && $upcomfee['sms']<2){ ?>
                                    <button id="sendreminder" data-tablename="tbl_member_<?php echo $_SESSION['userid']; ?>" data-memberphone="<?php echo $upcomfee['phone']; ?>" data-memberid="<?php echo $upcomfee['id']; ?>" data-membername="<?php if(isset($upcomfee['name']) && $upcomfee['name']!=""){echo $upcomfee['name'];} else{echo "N/A";} ?>" data-gymname="<?php if(isset($_SESSION['username']) && !empty($_SESSION['username'])){echo $_SESSION['username'];} else{echo "N/A";}?>" data-feesdate="<?php if(isset($upcomfee['fee_date']) && $upcomfee['fee_date']!=""){echo date("d-M-y",$upcomfee['fee_date']);} else{echo "N/A";} ?>" data-fees="<?php if(isset($upcomfee['package']) && $upcomfee['package']!="custom"){echo $upcomfee['packagedetail']['fees']; } else{echo $upcomfee['fees'];}?>" class="fee_btn_s1  reminderbutton dashboardreminderbutton" >Send Reminder</button>
                                <?php } ?>

                            </td>



                            <div class="modal fade" id="myModal_<?php echo $upcomfee['id']; ?>" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <form method="post" action="<?=site_url('admin/dashboard/payfee')?>">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title color-black">Pay Fee</h4>
                                        </div>
                                        <div class="modal-body color-black popupfeeform">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="f_name">Date</label>
                                                    <?php $cdate = date('Y-m-d');  ?>
                                                    <input  type="text"  class="form-control" value="<?php echo $cdate; ?>"  id="datepicker" name="payment_date" placeholder="">
                                                   <!-- <input  type="hidden"  class="form-control" value="<?php echo strtotime($cdate); ?>"  id="payment_date" name="payment_date" placeholder="">-->
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="f_name">Fees</label>
                                                    <input  type="text"  class="form-control" value="<?php if(isset($upcomfee['packagedetail']) && !empty($upcomfee['packagedetail'])){echo $upcomfee['packagedetail']['fees'];}else{ echo $upcomfee['fees'];} ?>"  id="fees" name="fees" placeholder="">
                                                   <!-- <input  type="hidden"  class="form-control" value="<?php echo $upcomfee['fees']; ?>"  id="fees" name="fees" placeholder="">-->
                                                    <input  type="hidden"  class="form-control" value="<?php echo $upcomfee['id']; ?>"  id="id" name="id" placeholder="">
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
                                            <!--<a href="<?php echo site_url('admin/members/payfee/'.$upcomfee['id'])?>" type="button" class="btn btn-default color-black">Submit</a>-->
                                            <button class="btn btn-default" type="submit">Submit</button>
                                        </div>
                                            </form>
                                    </div>
                                    <!-- END Modal content-->

                                </div>
                            </div>

                        </tr>
<?php endforeach;?>

<div class="modal fade" id="myModalreminder" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="<?=site_url('admin/dashboard/payfee')?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title color-black">Reminder Send Succesfully</h4>
                </div>
                <div class="modal-body color-black popupfeeform">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </form>
        </div>
        <!-- END Modal content-->

    </div>
</div>
                        </tbody>
                    </table>
                </div><!-- /.col -->
            </div><!-- /.row -->

</div>

            <!--pie chart code start-->
         <div class="rightdivwrapper"><div class="box-header customer">
                 <h3 class="box-title"><?php echo date("F"); ?> Fees Chart</h3>

             </div>
             <div class="chartinfo">
                 <p>Total Payable Memers: <span><?php echo $totalactivemembers; ?></span></p>
                 <p>Paid Fees: <span><?php echo $totalactivemembers-$pendingfeesthismonth; ?></span></p>
                 <p>Pending Fees: <span><?php echo $pendingfeesthismonth; ?></span></p>
             </div>

             <script src="https://code.highcharts.com/highcharts.js"></script>
             <script src="https://code.highcharts.com/highcharts-3d.js"></script>
             <script src="https://code.highcharts.com/modules/exporting.js"></script>
             <div class="mynewpiechart">
                 <div id="container" style="height: 400px"></div>
             </div>



             <!--<div id="specificChart" class="donut-size">
                <div class="pie-wrapper">
        <span class="label">
          <span class="num">0</span><span class="smaller">%</span>
        </span>
                    <div class="pie">
                        <div class="mleft_side left-side half-circle"></div>
                        <div class="mright_side right-side half-circle"></div>
                    </div>
                    <div class="shadow"></div>
                </div>
            </div>-->

         </div>
    </div>
           <!-- <div class="btns">
                <button id='update1'>57%
                </button>
                <button id='update2'>77%
                </button>
                <button id='update3'>100%
                </button>
            </div>-->
            <script>
                var totalpaidpersons=<?php echo $totalactivemembers-$pendingfeesthismonth; ?>;
                var totalpersons=<?php echo $totalactivemembers; ?>;
                //alert(totalpersons);
                var paidpercentage=totalpaidpersons/totalpersons*100;
                updateDonutChart('#specificChart', paidpercentage, true);
                $( "#update1" ).click(function() {
                    updateDonutChart('#specificChart', 57, true);
                });
                $( "#update2" ).click(function() {
                    updateDonutChart('#specificChart', 77, true);
                });
                $( "#update3" ).click(function() {
                    updateDonutChart('#specificChart', 100, true);
                });

            </script>
            <script type="text/javascript">

                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-36251023-1']);
                _gaq.push(['_setDomainName', 'jqueryscript.net']);
                _gaq.push(['_trackPageview']);

                (function() {
                    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                })();

            </script>


<!--pie chart code end-->





            <!--new pie chart code start-->



            <script>

                var totalpaidpersons=<?php echo $totalactivemembers-$pendingfeesthismonth; ?>;
                var totalpersons=<?php echo $totalactivemembers; ?>;
                //alert(totalpersons);
                var paidpercentage=totalpaidpersons/totalpersons*100;
                var remainingpercentage=100-paidpercentage;


                Highcharts.chart('container', {
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            depth: 35,
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}'
                            }
                        }
                    },
                    series: [{
                        type: 'pie',
                        name: 'Monthly Revenue',
                        data: [

                            {
                                name: 'Paid Fees',
                                y: paidpercentage,
                                sliced: true,
                                selected: true
                            },
                            ['Pending Fees', remainingpercentage],

                        ]
                    }]
                });
            </script>
            <!--new pie chart code end-->



