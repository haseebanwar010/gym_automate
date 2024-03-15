<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<section class="content">
    
   
                
        


            <div id="" class="content-wrapper">
                 <div class="box-header">
                  <h3 class="box-title">Stats</h3>
                </div>
                <div class="barchartwrapper">
        <div id = "barcontainer" style = "width: 100%; height: 400px; margin: 0 auto"></div>
      </div>

    </div>
    
</section>













<script>
    
        /*bar chart script start*/

        $(document).ready(function() {
            //alert(data.monthlyrevenue.September.totalrevenue);
            var chart = {
                type: 'bar'
            };
            var title = {
                text: 'Monthly Revenue'
            };
            var subtitle = {
                text: ''
            };
            var xAxis = {
                categories: ['January', 'Feburary', 'March', 'April', 'may', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                title: {
                    text: null
                }
            };
            var yAxis = {
                min: 0,
                title: {
                    text: 'Revenue (Rs)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            };
            var tooltip = {
                valueSuffix: ' Rs'
            };
            var plotOptions = {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            };
            var legend = {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 100,
                floating: true,
                borderWidth: 1,

                backgroundColor: (
                (Highcharts.theme && Highcharts.theme.legendBackgroundColor) ||
                '#FFFFFF'),
                shadow: true
            };
            var credits = {
                enabled: false
            };
            var series = [
                {
                    name: 'Year 2017',
                    data: [150, 200, 500,150, 200, 500,150, 200, 500,150, 200, 500]
                }
            ];

            var json = {};
            json.chart = chart;
            json.title = title;
            json.subtitle = subtitle;
            json.tooltip = tooltip;
            json.xAxis = xAxis;
            json.yAxis = yAxis;
            json.series = series;
            json.plotOptions = plotOptions;
            json.legend = legend;
            json.credits = credits;
            $('#barcontainer').highcharts(json);
        });

        /*bar chart script end*/
</script>