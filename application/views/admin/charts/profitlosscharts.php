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
              <h3 class="box-title">Expense & Revenue Bar Chart</h3>
            </div>
                <div class="chartfilters">
                    <form autocomplete="off">
                    <div class=" col-sm-4">
                        <input type="text" class="form-control my_datepicker" value="" id="startdateprofitlossfilt2" name="start_date" placeholder="Please Select Start Date">
                    </div>
                    <div class=" col-sm-4">
                        <input type="text" class="form-control datepicker" value="" id="enddateprofitlossfilt2" name="start_date" placeholder="Please Select End Date">
                    </div>
                    </form>
                    <div class="col-sm-2">
                        <button type="submit" class="date_btns btn btn-info filterchartcustombtn" id="submtfiltprofitloss1">Submit</button>
                    </div>
                </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="profitlossbarChart" style="height:230px"></canvas>
              </div>
            </div>
                <div class="graphlegends">
                <div class="singlegend">
                    <div class="legcolor legcolorred"></div><span>Expense</span>
                </div>
                <div class="singlegend">
                    <div class="legcolor"></div><span>Revenue</span>
                </div>
            </div>
                
                
                <div class="box-body">
                <table id="ajaxtable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Month</th>
                  <th>Total Expense</th>
                  <th>Total Income</th>
                  <th>Total Revenue</th>
                </tr>
                </thead>
                <tbody id="tableajaxdata">
                    
                </tbody>
                <tfoot>
                <tr>
                  <th>Month</th>
                  <th>Total Expense</th>
                  <th>Total Income</th>
                  <th>Total Revenue</th>
                </tr>
                </tfoot>
              </table>
                </div>
                
                
                
                
                
          </div>
            
            
            
        </div>
<!--
        <div class="col-md-12">
            <div class="box box-success">
                
                
                
    
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
              <div id="container" style="width: 75%;">
		<canvas id="canvas"></canvas>
	</div>
	<button id="randomizeData">Randomize Data</button>
	<button id="addDataset">Add Dataset</button>
	<button id="removeDataset">Remove Dataset</button>
	<button id="addData">Add Data</button>
	<button id="removeData">Remove Data</button>
                <div class="chart">
                <canvas id="profitlossbarChart2" style="height:230px"></canvas>
                    
              </div>
            </div>      
          </div>
        </div>
-->
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
      window.initializeprofitlosschart=function(labelsdata,expensedata,incomedate){
    var areaChartData = {
      labels  : labelsdata,
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(245, 105, 84, 1)',
          strokeColor         : 'rgba(245, 105, 84, 1)',
          pointColor          : 'rgba(245, 105, 84, 1)',
          pointStrokeColor    : '#f56954',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(245, 105, 84, 1)',
          data                : expensedata
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : incomedate
        }
      ]
    }
    var barChartCanvas                   = $('#profitlossbarChart').get(0).getContext('2d');
          if(window.barChart != undefined){
                window.barChart.destroy(); 
            }
//    var barChart                         = new Chart(barChartCanvas)
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

    barChartOptions.datasetFill = false;
          window.barChart= new Chart(barChartCanvas).Bar(barChartData, barChartOptions);
//    barChart.Bar(barChartData, barChartOptions);
      }
      window.initializeprofitlosschart2=function(labelsdata,revenue){
    var areaChartData = {
      labels  : labelsdata,
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(245, 105, 84, 1)',
          strokeColor         : 'rgba(245, 105, 84, 1)',
          pointColor          : 'rgba(245, 105, 84, 1)',
          pointStrokeColor    : '#f56954',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(245, 105, 84, 1)',
          data                : revenue
        }
      ]
    }
    
    var barChartCanvas                   = $('#profitlossbarChart2').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    
    var barChartData                     = areaChartData
   
    var barChartOptions                  = {
        barDatasetSpacing : 0,
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
                    initializeprofitlosschart(response.label_data,response.total_expence,response.total_income);
//                    initializeprofitlosschart2(response.label_data,response.revenue);
                    var htmltoassign="";
                    for(var j=0;j<response.tabledata.length;j++){
                        htmltoassign+="<tr><td>"+response.tabledata[j].date+"</td><td>"+response.tabledata[j].total_expence+"</td><td>"+response.tabledata[j].total_income+"</td><td>"+response.tabledata[j].revenue+"</td></tr>";
                    }
                    $('#tableajaxdata').html(htmltoassign);
                    $('#ajaxtable').DataTable( {
                        'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false,
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
                }
            });
      
      
      
  });
    
    
    $('#submtfiltprofitloss1').click(function(){
         
         var startdateval = jQuery('#startdateprofitlossfilt2').val();
         var enddateval = jQuery('#enddateprofitlossfilt2').val();
         
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
                    initializeprofitlosschart(response.label_data,response.total_expence,response.total_income);
                     var htmltoassign="";
                    for(var j=0;j<response.tabledata.length;j++){
                        htmltoassign+="<tr><td>"+response.tabledata[j].date+"</td><td>"+response.tabledata[j].total_expence+"</td><td>"+response.tabledata[j].total_income+"</td><td>"+response.tabledata[j].revenue+"</td></tr>";
                    }
                    $('#tableajaxdata').html(htmltoassign);
                }
                });
         }
     });
    /*$('#submtfiltprofitloss3').click(function(){
         
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
    */
    
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