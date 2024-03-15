<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Charts
            <small>Profit & Loss Charts</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $baseUrl; ?>profitlosscharts">Profit & Loss Charts</a></li>
            <li class="active">All Profit & Loss Charts</li>
        </ol>
    </section>

    <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                
                
                
    
          <div class="box-header with-border">
              <h3 class="box-title">Profit & Loss Bar Chart</h3>
            </div>
                <div class="chartfilters">
                    <form autocomplete="off">
                    <div class=" col-sm-4">
                        <input type="text" class="form-control datepicker" value="" id="startdateprofitlossfilt3" name="start_date" placeholder="Please Select Start Date">
                    </div>
                    <div class=" col-sm-4">
                        <input type="text" class="form-control datepicker" value="" id="enddateprofitlossfilt3" name="start_date" placeholder="Please Select End Date">
                    </div>
                    
                    </form>
                    <div class="col-sm-2">
                        <button type="" class="date_btns btn btn-info filterchartcustombtn" id="submtfiltprofitloss3">Submit</button>
                    </div>
                </div>
            <div class="box-body">
              <div id="container" style="width: 100%;">
		<canvas id="canvas"></canvas>
	</div>
	
            </div>      
                
                
<!--
            <div class="box-header with-border">
              <h3 class="box-title">Profit & Loss Bar Chart</h3>
            </div>
                <div class="chartfilters">
                    <div class=" col-sm-4">
                        <input type="text" class="form-control datepicker" value="" id="startdateprofitlossfilt3" name="start_date" placeholder="Please Select Start Date">
                    </div>
                    <div class=" col-sm-4">
                        <input type="text" class="form-control datepicker" value="" id="enddateprofitlossfilt3" name="start_date" placeholder="Please Select End Date">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="date_btns btn btn-info filterchartcustombtn" id="submtfiltprofitloss3">Submit</button>
                    </div>
                </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="profitlossbarChart2" style="height:230px"></canvas>
              </div>
            </div>
-->
          </div>
        </div>
    </div>
</section>
</div>





<!--Charts Scripting Start-->

<script>
  $(function () {
      var baseurl='<?php echo $baseUrl; ?>';
      var barChartData;
      //-------------
    //- BAR CHART -
    //-------------
     window.initializeprofitlosschart2=function(labelsdata,revenue){
         var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		var color = Chart.helpers.color;
		window.barChartData = {
			labels: labelsdata,
			datasets: [{
				label: 'Monthly Revenue',
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 1,
				data: revenue
			},
//                       {
//				label: 'Dataset 2',
//				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
//				borderColor: window.chartColors.blue,
//				borderWidth: 1,
//				data: [
//					randomScalingFactor(),
//					randomScalingFactor(),
//					randomScalingFactor(),
//					randomScalingFactor(),
//					randomScalingFactor(),
//					randomScalingFactor(),
//					randomScalingFactor()
//				]
//			}
                      ]

		};
         var ctx = document.getElementById('canvas').getContext('2d');
         if(window.myBar != undefined){
                window.myBar.destroy(); 
            }
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: window.barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: ''
					}
				}
			});
     }
            $.ajax({
                url: baseurl+'admin/charts/getprofitlossdata', // point to server-side PHP script 
                dataType: 'JSON',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: "",                         
                type: 'post',
                success: function(response){
                    console.log(response);
                    initializeprofitlosschart2(response.label_data,response.revenue);
                }
            });
      
      
      
  });
    
    $('#submtfiltprofitloss3').click(function(){
         window.barChartData.labels.splice(-1, 1); // remove the label first

			window.barChartData.datasets.forEach(function(dataset) {
                console.log(window.barChartData);
                dataset.data.pop();
			});
        window.barChartData=new Array();
        console.log('yes');
       console.log(window.barChartData);
         var startdateval = jQuery('#startdateprofitlossfilt3').val();
         var enddateval = jQuery('#enddateprofitlossfilt3').val();
         
         if(startdateval!="" && enddateval!=""){
             
             var form_data = new FormData();
                form_data.append('startdate', startdateval);
                form_data.append('enddate', enddateval);
                var baseurl='<?php echo $baseUrl; ?>';
                jQuery.ajax({
            
                url: baseurl+'admin/charts/getprofitlossdata', // point to server-side PHP script 
                dataType: 'JSON',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(response){
                    console.log(response);
                    initializeprofitlosschart2(response.label_data,response.revenue);
                }
                });
         }
     });
    
    
//    var data = {
//    labels: ["January", "February", "March", "April", "May", "June", "July", "August"],
//    datasets: [
//        {
//            label: "My First dataset",
//            fillColor: "rgba(220,220,220,0.5)",
//            strokeColor: "rgba(220,220,220,0.8)",
//            highlightFill: "rgba(220,220,220,0.75)",
//            highlightStroke: "rgba(220,220,220,1)",
//            data: [65, 59, 80, 81, 56, 55, 40, -30]
//        },
//        {
//            label: "My Second dataset",
//            fillColor: "rgba(151,187,205,0.5)",
//            strokeColor: "rgba(151,187,205,0.8)",
//            highlightFill: "rgba(151,187,205,0.75)",
//            highlightStroke: "rgba(151,187,205,1)",
//            data: [28, 48, 40, 19, 86, 27, 90, -42]
//        }
//    ]
//};
//
//var options = {
//    scaleBeginAtZero: false,
//    responsive: true,
//    scaleStartValue : -50 
//};
//
//var ctx = document.getElementById("myChart").getContext("2d");
//var myBarChart = new Chart(ctx).Bar(data, options);
    
  
</script>


<!--Charts Scripting End-->