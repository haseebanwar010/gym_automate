<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reports
            <small>Member Registrations</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Reports</li>
            <li class="active"> <a href="<?php echo $baseUrl; ?>reports">Member Registrations</a></li>
        </ol>
    </section>

    <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Members Registration</h3>
            </div>
                <div class="chartfilters">
                    <form method="post" action="" autocomplete="off">
                    <div class=" col-sm-4">
                        <input type="text" class="form-control datepicker" value="<?php if(isset($_POST['startdate']) && !empty($_POST['startdate'])){ echo $_POST['startdate']; } ?>" id="startdatereportsfilt1" name="startdate" placeholder="Please Select Start Date">
                    </div>
                    <div class=" col-sm-4">
                        <input type="text" class="form-control datepicker" value="<?php if(isset($_POST['enddate']) && !empty($_POST['enddate'])){ echo $_POST['enddate']; } ?>" id="enddatereportsfilt1" name="enddate" placeholder="Please Select End Date">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="date_btns btn btn-info filterchartcustombtn" id="submitreports1">Submit</button>
                    </div>
                    </form>
                </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="registrationChart" style="height:230px"></canvas>
              </div>
                
                
                
                
              <table id="registrationtable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Gender</th>
                  <?php if($this->session->userdata['show_fees']==1){ ?><th class="desktoptab">Fees</th><?php } ?>
                  <?php if($this->session->userdata['show_fees']==1){ ?><th class="desktoptab">Admission Fees</th><?php } ?>
                  <th>Joining Date</th>
                  <th>Fees Date</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($members as $member){ ?>
                <tr>
                  <td><?php echo $member['name']; ?></td>
                  <td><?php echo $member['phone']; ?></td>
                  <td><?php if(isset($member['gender']) && $member['gender']!=""){echo $member['gender'];} else{echo "N/A";} ?></td>
                  <?php if($this->session->userdata['show_fees']==1){ ?>
                            <?php if(isset($member['packagedetail']) && !empty($member['packagedetail'])){?>
                                <td><?php echo $this->session->userdata['currency_symbol']."".$member['packagedetail']['fees']; ?></td>
                    <td><?php echo $this->session->userdata['currency_symbol']."".$member['packagedetail']['admission_fees']; ?></td>
                            <?php } else{?>
                            <td><?php echo $this->session->userdata['currency_symbol']."".$member['fees']; ?></td>
                    <td><?php echo $this->session->userdata['currency_symbol']."".$member['admission_fees']; ?></td>
                            <?php } } ?>
                  
                  <td><?php echo date('d-M-Y',$member['joining_date']); ?></td>
                  <td><?php echo date('d-M-Y',$member['fee_date']); ?></td>
                </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Gender</th>
                  <?php if($this->session->userdata['show_fees']==1){ ?><th class="desktoptab">Fees</th><?php } ?>
                    <?php if($this->session->userdata['show_fees']==1){ ?><th class="desktoptab">Admission Fees</th><?php } ?>
                  <th>Joining Date</th>
                  <th>Fees Date</th>
                </tr>
                </tfoot>
              </table>
                
                
                
            </div>
          </div>
            
            
        </div>
        
    </div>
</section>
</div>





<!--Charts Scripting Start-->

<script>
  $(function () {
      var baseurl='<?php echo $baseUrl; ?>';
      //-------------
    //- BAR CHART -
    //-------------
      
//      getprofitlossdata
   
      window.initializereportschart=function(labelsdata,registration){
    var areaChartData = {
      labels  : labelsdata,
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(0, 166, 90, 1)',
          strokeColor         : 'rgba(0, 166, 90, 1)',
          pointColor          : 'rgba(0, 166, 90, 1)',
          pointStrokeColor    : '#f56954',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(0, 166, 90, 1)',
          data                : registration
        }
      ]
    }
    
    var barChartCanvas                   = $('#registrationChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    
    var barChartData                     = areaChartData
   
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : false,
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
      }
      initializereportschart(<?php echo json_encode($labels); ?>,<?php echo json_encode($number_of_registrations); ?>);
      
      
      
//            $.ajax({
//                url: baseurl+'admin/charts/registartionreportsdata', // point to server-side PHP script 
//                dataType: 'JSON',  // what to expect back from the PHP script, if anything
//                cache: false,
//                contentType: false,
//                processData: false,
//                data: "",                         
//                type: 'post',
//                success: function(response){
//                    console.log(response);
//                    initializereportschart(response.labels,response.number_of_registrations);
//                }
//            });
      
      
      
  });
    
    
//    $('#submitreports1').click(function(){
//         
//         var startdateval = jQuery('#startdatereportsfilt1').val();
//         var enddateval = jQuery('#enddatereportsfilt1').val();
//         
//         if(startdateval!="" && enddateval!=""){
//             
//             var form_data = new FormData();
//                form_data.append('startdate', startdateval);
//                form_data.append('enddate', enddateval);
//                var baseurl='<?php echo $baseUrl; ?>';
//                jQuery.ajax({
//            
//                url: baseurl+'admin/charts/registartionreportsdata',
//                dataType: 'JSON',  
//                cache: false,
//                contentType: false,
//                processData: false,
//                data: form_data,                         
//                type: 'post',
//                success: function(response){
//                    console.log(response);
//                    initializereportschart(response.labels,response.number_of_registrations);
//                }
//                });
//         }
//     });
   
    
  
</script>



<!--Charts Scripting End-->