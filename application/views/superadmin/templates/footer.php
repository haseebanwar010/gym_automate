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

</div>

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

<script src="<?php echo $baseUrl; ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $baseUrl; ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>



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
      //Initialize Select2 Elements
    $('.select2').select2()
    $('#example1').DataTable({
        'ordering'    : false,
    })
      $('.example1').DataTable({
        'ordering'    : false,
    })
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
        
        
        $('.joining_date').change(function(){
            var selectedval=$('.joining_date').val();
            var NewDate = new Date(selectedval);
            NewDate.setMonth(NewDate.getMonth() + 1);
            
            var formateddate=NewDate.getMonth()+1 + '/' + NewDate.getDate() + '/' +  NewDate.getFullYear();
            
            
            //var newvalue  = selectedval.setMonth(selectedval.getMonth()+8);
            //alert(newvalue);
            $('.fee_date').val(formateddate);
        });
        
	});

</script>




<script>
    $(document).ready(function(){
        $(".slideadvancedoptions").click(function(){
            $(".advancememberoptions").slideToggle();
        });
        $('.packgchanger').on('change', function() {
		if(this.value=="custom"){
			$(".custompckg").show("fast");
		}
		else{
			$(".custompckg").hide("fast");
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
	$(document).ready(function() {
		$("#supercountrychanger").change(function () {
			if ($(this).data('options') === undefined) {
				/*Taking an array of all options-2 and kind of embedding it on the select1*/
				$(this).data('options', $('#supercity option').clone());
			}
			var id = $(this).val();
			var options = $(this).data('options').filter('[data-countryid=' + id + ']');
			$('#supercity').html(options);
		});
	});
</script>
<script>
    $(document).ready(function(){
        $('body').loading('stop');
    })
</script>



</body>
</html>