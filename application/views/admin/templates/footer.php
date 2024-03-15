<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2017-2018 <a target="_blank" href="http://www.gymautomate.com/">Gymautomate</a>.</strong> All rights
    reserved.
  </footer>
<!--<aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
      </div>
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>

      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
        </form>
      </div>
    </div>
  </aside>
-->
</div>

<!-- ./wrapper -->

<!-- jQuery 3 -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $baseUrl; ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo $baseUrl; ?>assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo $baseUrl; ?>assets/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $baseUrl; ?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo $baseUrl; ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo $baseUrl; ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $baseUrl; ?>assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $baseUrl; ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo $baseUrl; ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo $baseUrl; ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo $baseUrl; ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $baseUrl; ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->

<!--
<script src="<?php echo $baseUrl; ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $baseUrl; ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
-->
<!--Export extension links start-->

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<!--Export extension links end-->


<script src="<?php echo $baseUrl; ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $baseUrl; ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $baseUrl; ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $baseUrl; ?>assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $baseUrl; ?>assets/dist/js/demo.js"></script>
<script src="<?php echo $baseUrl; ?>assets/bower_components/ckeditor/ckeditor.js"></script>
<!-- Select2 -->
<script src="<?php echo $baseUrl; ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo $baseUrl; ?>assets/plugins/iCheck/icheck.min.js"></script>


<?php if($page!="profitlosscharts2"){ ?>
<script src="<?php echo $baseUrl; ?>assets/bower_components/chart.js/Chart.js"></script>
<?php } ?>
<script src="<?php echo $baseUrl; ?>assets/bower_components/jquery-knob/js/jquery.knob.js"></script>
<script src="<?php echo $baseUrl; ?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- fullCalendar -->
<script src="<?php echo $baseUrl; ?>assets/bower_components/moment/moment.js"></script>
<script src="<?php echo $baseUrl; ?>assets/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<!-- Page specific script -->


<script>
  $(function () {
      var reference_number_status="<?php echo $this->session->userdata['referncenumber_status']; ?>";
	  console.log(reference_number_status);
      if(reference_number_status==true){
          $('#example1').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5,6]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            }
        ]
    } );
          
      }else{
          $('#example1').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
			  
          buttons: [
//            {
//                extend: 'copy',
//                exportOptions: {
//                    columns: [ 0, 1, 2, 3, 4, 5, 6]
//                }
//            },
//            {
//                extend: 'csv',
//                exportOptions: {
//                    columns: [ 0, 1, 2, 3, 4, 5, 6]
//                }
//            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            }
        ]
//        buttons: [
//            'copy', 'csv', 'excel', 'pdf', 'print'
//        ]
    } );
      }
      
      $('#chartstable').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            }
        ]
    } );
	  
          $('#membertypes').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }
            }
        ]
    } );
	     	  
	          
      $('#body_composition_data').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                }
            },
            {
                extend: 'pdf',
				orientation: 'landscape',
                pageSize: 'A3',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                }
            },
            {
                extend: 'print',
				orientation: 'landscape',
                pageSize: 'A3',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
                }
            }
			
        ]
    } );
	  
	        
	  var member_att_chart_month=$('#memberattendencechart').val();
	  if(member_att_chart_month==28){
      $('#memberattendencelistchart').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34]
                }
            },
            {
                extend: 'pdf',
				orientation: 'landscape',
                pageSize: 'lEGAL',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34]
                }
            },
            {
                extend: 'print',
				orientation: 'landscape',
                pageSize: 'A3',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34]
                }
            }
        ]
    } );
	  }
	  
	  if(member_att_chart_month==29){
      $('#memberattendencelistchart').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35]
                }
            },
            {
                extend: 'pdf',
				orientation: 'landscape',
                pageSize: 'lEGAL',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35]
                }
            },
            {
                extend: 'print',
				orientation: 'landscape',
                pageSize: 'A3',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35]
                }
            }
        ]
    } );
	  }
	  
	  if(member_att_chart_month==30){
      $('#memberattendencelistchart').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36]
                }
            },
            {
                extend: 'pdf',
				orientation: 'landscape',
                pageSize: 'lEGAL',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36]
                }
            },
            {
                extend: 'print',
				orientation: 'landscape',
                pageSize: 'A3',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36]
                }
            }
        ]
    } );
	  }
	  
	  if(member_att_chart_month==31){
      $('#memberattendencelistchart').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
		  'pageLength' : 100,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37]
                }
            },
            {
                extend: 'pdf',
				orientation: 'landscape',
                pageSize: 'lEGAL',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37]
                }
            },
            {
                extend: 'print',
				orientation: 'landscape',
                pageSize: 'A3',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37]
                }
            }
        ]
    } );
	  }
	  
	  
      $('#registrationtable').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            }
        ]
    } );
      $('#feesreporttable').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }
            }
        ]
    } );
      $('#packagestable').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4]
                }
            }
        ]
    } );
      $('#adminuserstable').DataTable( {
        dom: 'lBfrtip',
          'ordering'    : false,
          buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            }
        ]
    } );
      //Initialize Select2 Elements
    $('.select2').select2()
      
      $('.example1').DataTable( {
        dom: 'Bfrtip',
        'ordering'    : false,
        buttons: [
             'excel', 'pdf', 'print'
        ]
    } );
//    $('#example1').DataTable({
//        'ordering'    : false,
//    })
//      $('.example1').DataTable({
//        'ordering'    : false,
//    })
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
      $('#datepicker').datepicker({
      autoclose: true
    })
      $('.datepicker').datepicker({
      autoclose: true
    })
      $('.timepicker').timepicker({
      showInputs: false
    })
      $('.monthpicker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
   $('#custom_month_picker input').datepicker({
//	   viewMode: 'years',
//        changeMonth: true,
//        changeYear: true,
//        showButtonPanel: true,
//	   dateFormat: 'mm yyyy',
//	   startView: "months",
//	   minViewMode: "months",
//        
//        onClose: function(dateText, inst) { 
//            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
//        }
	changeMonth: true,
        changeYear: true,
	autoclose: true,
	minViewMode: 1,
    maxViewMode: 2,
    todayBtn: false
	  
	   
    });
      
      $('.my_datepicker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
  })
    
</script>
<!--
<script>
  $(function () {
    CKEDITOR.replace('editor1')
    $('.textarea').wysihtml5()
  })
</script>
-->




<script>
            
        </script>




</body>
</html>


<script>


	$( document ).ready(function() {
        var baseurl="<?php echo $baseUrl; ?>";
        //alert(baseurl);
        $('.attendencechanger').change(function() {
            var memberid=$(this).data("memberid");
            var tablename=$(this).data("tablename");
            if($(this).is(":checked")) {
                var url=baseurl+"admin/dashboard/addcurrentattendence/";
			$.ajax({
				url: url,
				type: 'POST',
				data: { tablename: tablename, memberid : memberid} ,

				success: function(data){
                    if(data=="success"){
                        $( ".attendencemessage" ).show();
                    }
					console.log(data);
				},
				error: function(){
				//	alert('error');

				}
			});
                
                
            }
            
            
        });
        
        
		$("#sendreminder").click(function(){
			
			
			var tablename=$(this).attr("data-tablename");
			var gymid=$(this).attr("data-gymid");
			var memberid=$(this).attr("data-memberid");

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



			var fees=$(this).attr("data-fees");
			var feesdate=$(this).attr("data-feesdate");
			var gymname=$(this).attr("data-gymname");
			var gymphone=$(this).attr("data-gymphone");
            var gymaddress='<?php echo $_SESSION['address']; ?>';
			var membername=$(this).attr("data-membername");
			var memberphone=$(this).attr("data-memberphone");
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
					alert('Message has been sent succesfully');
					console.log(data);
				},
				error: function(){
					//alert('error');
					alert('Message has been sent succesfully');
				}
			});



		});
        
        $('.joining_date').change(function(){
            var selectedval=$('.joining_date').val();
            var NewDate = new Date(selectedval);
            NewDate.setMonth(NewDate.getMonth() + 1);
            
            var formateddate=NewDate.getMonth()+1 + '/' + NewDate.getDate() + '/' +  NewDate.getFullYear();
            
            
            //var newvalue  = selectedval.setMonth(selectedval.getMonth()+8);
            //alert(newvalue);
            
            var packageduration=0;
            var packagetype=$('.packgchanger').val();
            if(packagetype==''){
                packageduration=1;
                updatefeedateoption(packageduration);
            }
            else if(packagetype=='custom'){
                var innserselectval=$('.innerdurationselect').val();
                if(innserselectval==""){
                    packageduration=1;
                    updatefeedateoption(packageduration);
                }else{
                    packageduration=innserselectval;
                    updatefeedateoption(packageduration);
                }
            }else{
                var packageid=packagetype;
            var baseurl="<?php echo $baseUrl; ?>";
            var url=baseurl+"admin/members/get_packagedetail_ajax";
			$.ajax({
				url: url,
                dataType: 'json',
				type: 'POST',
				data: { packageid : packageid } ,

				success: function(data){
					console.log(data);
                    packageduration=data.duration;
                    updatefeedateoption(packageduration);
				},
				error: function(){
				}
			});
            }
            function updatefeedateoption(duration){
                    var selectedval=$('.joining_date').val();
                    console.log(selectedval);
                    var selectedval=$('.joining_date').val();
                    var NewDate = new Date(selectedval);
                    var monthtoadd=parseInt(duration)+1;
                    NewDate.setMonth(NewDate.getMonth() + monthtoadd);
                    var yeardecryment=NewDate.getFullYear()-1
                    console.log(NewDate.getFullYear());
                    if(NewDate.getMonth()==0){
                        var formateddate='12/' + NewDate.getDate() + '/' +  yeardecryment;
                    }else{
                        var formateddate=NewDate.getMonth() + '/' + NewDate.getDate() + '/' +  NewDate.getFullYear();
                    }
                    
                    console.log(formateddate);
            
            $('.fee_date').val(formateddate);
            }
            
        });
        
	});

</script>




<script>
    $(document).ready(function(){
        $(".slideadvancedoptions").click(function(){
            $(".advancememberoptions").slideToggle();
        });
        $('.trainerchanger').on('change', function() {
          if(this.value!="" && this.value!=0){
          var trainingfees=$(this).find(':selected').data('trainingfees');
          var commission_percentage=$(this).find(':selected').data('commissionpercentage');
          $('#training_fees').val(trainingfees);
          $('#commission_percentage').val(commission_percentage);
          $('.trainer_details').show();
          }else{
            $('.trainer_details').hide();
          }
        });
        $('.packgchanger').on('change', function() {
		if(this.value=="custom"){
			$(".custompckg").show("fast");
		}
		else{
            var packageid=this.value;
            var baseurl="<?php echo $baseUrl; ?>";
            var url=baseurl+"admin/members/get_packagedetail_ajax";
			$.ajax({
				url: url,
                dataType: 'json',
				type: 'POST',
				data: { packageid : packageid } ,

				success: function(data){
					console.log(data);
                    var packageduration=parseInt(data.duration);
                    var selectedval=$('.joining_date').val();
                    console.log(selectedval);
                    var selectedval=$('.joining_date').val();
                    var NewDate = new Date(selectedval);
                    var monthtoadd=parseInt(data.duration)+1;
                    NewDate.setMonth(NewDate.getMonth() + monthtoadd);
                    var yeardecryment=NewDate.getFullYear()-1
                    console.log(NewDate.getFullYear());
                    if(NewDate.getMonth()==0){
                        var formateddate='12/' + NewDate.getDate() + '/' +  yeardecryment;
                    }else{
                        var formateddate=NewDate.getMonth() + '/' + NewDate.getDate() + '/' +  NewDate.getFullYear();
                    }
                    
                    console.log(formateddate);
                    $('.fee_date').val(formateddate);
				},
				error: function(){
				}
			});
            
            
			$(".custompckg").hide("fast");
		}
	   });
        $('.innerdurationselect').on('change', function() {
                    var selectedval=$('.joining_date').val();
                    console.log(selectedval);
                    var selectedval=$('.joining_date').val();
                    var NewDate = new Date(selectedval);
                    var monthtoadd=1+parseInt($('.innerdurationselect').val());
                    NewDate.setMonth(NewDate.getMonth() + monthtoadd);
                    var yeardecryment=NewDate.getFullYear()-1
                    console.log(NewDate.getFullYear());
                    if(NewDate.getMonth()==0){
                        var formateddate='12/' + NewDate.getDate() + '/' +  yeardecryment;
                    }else{
                        var formateddate=NewDate.getMonth() + '/' + NewDate.getDate() + '/' +  NewDate.getFullYear();
                    }
                $('.fee_date').val(formateddate);
        });
        $('#payment_radio').on('change', function() {
            if ($("input[name='payment_radio'][value='1']").prop("checked")){
                var packageduration=1;
                    var selectedval=$('.joining_date').val();
                    console.log(selectedval);
                    var selectedval=$('.joining_date').val();
                    var NewDate = new Date(selectedval);
                    var monthtoadd=1+1;
                    NewDate.setMonth(NewDate.getMonth() + monthtoadd);
                    var yeardecryment=NewDate.getFullYear()-1
                    console.log(NewDate.getFullYear());
                    if(NewDate.getMonth()==0){
                        var formateddate='12/' + NewDate.getDate() + '/' +  yeardecryment;
                    }else{
                        var formateddate=NewDate.getMonth() + '/' + NewDate.getDate() + '/' +  NewDate.getFullYear();
                    }
                $('.fee_date').val(formateddate);
            }
            else{
                //alert('not checked');
            }
        });
    });
     $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
</script>

<script>
    $(document).ready(function(){
        $('body').loading('stop');
    })
</script>



</body>
</html>