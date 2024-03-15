<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Charts
            <small>Attendence Charts</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $baseUrl; ?>attendencecharts">Attendence Charts</a></li>
            <li class="active">All Attendence Charts</li>
        </ol>
    </section>

    <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Attendence Chart Day Wise</h3>
                    <div class="headlabels">
                        <p>Total Active Members: <strong id="don_totalactive"><?php echo $totalactivemembers; ?></strong></p>
                        <p>Total Present Today: <strong id="don_totalentrance"><?php echo $total_todays_entrances; ?></strong></p>
                    </div>
                </div>
                
                <div class="chartfilters">
                    <form autocomplete="off">
                    <div class=" col-sm-4">
                        <input type="text" class="form-control datepicker" value="" id="datefilt1" name="start_date" placeholder="Please Select Date">
                    </div>
                    </form>
                    <div class="col-sm-2">
                        <button type="submit" class="date_btns btn btn-info filterchartcustombtn" id="submtfilt1">Submit</button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="attendencebydate" style="height:250px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title text-warning">Attendence Comparison Between Days</h3>
                </div>
                <div class="chartfilters">
                    <form autocomplete="off" class="col-sm-8">
                    <div class=" col-sm-6">
                        <input type="text" class="form-control datepicker" value="" id="startdatefilt2" name="start_date" placeholder="Please Select Start Date">
                    </div>
                    <div class=" col-sm-6">
                        <input type="text" class="form-control datepicker" value="" id="enddatefilt2" name="start_date" placeholder="Please Select End Date">
                    </div>
                    </form>
                    <div class="col-sm-2">
                        <button type="submit" class="date_btns btn btn-info filterchartcustombtn" id="submtfilt2">Submit</button>
                    </div>
                </div>
                
                <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
              </div>
            </div>
            </div>
        </div>
    </div>
</section>
</div>





<!--Charts Scripting Start-->

<script>
    var barChart;
    $(function () {
        var baseurl='<?php echo $baseUrl; ?>';
    var $=jQuery;
        window.intializeattendencechart=function(totalactivemembers,totalpresent){
            
//              var ctxLine = document.getElementById("line-chart").getContext("2d");
//    if(window.bar != undefined) 
//    window.bar.destroy(); 
//    window.bar = new Chart(ctxLine, {});  
            
            
    var pieChartCanvas = $('#attendencebydate').get(0).getContext('2d')
//    var pieChart       = new Chart(pieChartCanvas);
            
            if(window.pieChart != undefined){
                window.pieChart.destroy(); 
            }
    
//    window.pieChart = new Chart(pieChartCanvas, {});  
            
    var PieData        = [
      {
        value    : totalactivemembers,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'Total Active Members'
      },
      {
        value    : totalpresent,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'Total Present'
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
   window.pieChart= new Chart(pieChartCanvas).Doughnut(PieData, pieOptions);
//    pieChart.Doughnut(PieData, pieOptions)
        }
        window.initializeattendencebarchart=function(labelsdata,valuedata){
            
            
            //-------------
    //- BAR CHART -
    //-------------
    var areaChartData = {
      labels  : labelsdata,
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(0, 192, 239, 1)',
          strokeColor         : 'rgba(0, 192, 239, 1)',
          pointColor          : 'rgba(0, 192, 239, 1)',
          pointStrokeColor    : '#00c0ef',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(0, 192, 239, 1)',
          data                : valuedata
        }
      ]
    }
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d');
            if(window.barChart != undefined){
                window.barChart.destroy(); 
            }
    console.log(barChartCanvas);
        
//    barChart                         = new Chart(barChartCanvas)
            
    var barChartData                     = areaChartData
//    barChartData.datasets[1].fillColor   = '#00a65a'
//    barChartData.datasets[1].strokeColor = '#00a65a'
//    barChartData.datasets[1].pointColor  = '#00a65a'
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

    barChartOptions.datasetFill = true;
            window.barChart= new Chart(barChartCanvas).Bar(barChartData, barChartOptions);
         
        }
        
    var totalactivemembers="<?php echo $totalactivemembers; ?>";
    var totalpresenttoday="<?php echo $total_todays_entrances; ?>";
    intializeattendencechart(totalactivemembers,totalpresenttoday);
        
        jQuery.ajax({
        
                url: baseurl+'admin/charts/attendencechart1filter2', // point to server-side PHP script 
                dataType: 'JSON',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: "",                         
                type: 'post',
                success: function(response){
                    console.log(response);
                    initializeattendencebarchart(response.labeldata,response.valuedata);
                }
       });
        
        
        
//        initializeattendencebarchart();
    });
    
    
    
    
    
     $('#submtfilt2').click(function(){
        
         var startdateval = jQuery('#startdatefilt2').val();
         var enddateval = jQuery('#enddatefilt2').val();
         
         if(startdateval!="" && enddateval!=""){
             
             var form_data = new FormData();
                form_data.append('startdate', startdateval);
                form_data.append('enddate', enddateval);
                var baseurl='<?php echo $baseUrl; ?>';
                jQuery.ajax({
            
                url: baseurl+'admin/charts/attendencechart1filter2', // point to server-side PHP script 
                dataType: 'JSON',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(response){
                    console.log(response);
                    initializeattendencebarchart(response.labeldata,response.valuedata);
                }
                });
         }
     });
     $('#submtfilt1').click(function(){
         
            var dateval = jQuery('#datefilt1').val();
            if(dateval!=null && dateval!=undefined && dateval!=""){
                var baseurl='<?php echo $baseUrl; ?>';
                var form_data = new FormData();
                form_data.append('date', dateval);
                jQuery.ajax({
        
                url: baseurl+'admin/charts/attendencechart1filter1', // point to server-side PHP script 
                dataType: 'JSON',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(response){
                    console.log(response);
                    $('#don_totalactive').text(response.totalactivemembers);
                    $('#don_totalentrance').text(response.total_todays_entrances);
                    intializeattendencechart(response.totalactivemembers,response.total_todays_entrances);
                }
                });
            }
        });
    
    $(function () {
    $(".sparkline").each(function () {
      var $this = $(this);
      $this.sparkline('html', $this.data());
    });

    });

    
</script>


<!--Charts Scripting End-->