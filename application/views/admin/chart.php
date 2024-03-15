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


<?php


?>


            <div id="wrapper" class="chartswrapper">
                <div class="chart">
                    <h3>Monthly Revenue</h3>
                    <table id="data-table" border="1" cellpadding="10" cellspacing="0"
                           summary="Percentage of knowledge acquired during my experience
            for each technology or language.">
                        <thead>
                        <tr>
                            <td>&nbsp;</td>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>


                        <?php foreach ($monthlyrevenue as $smonthlyrevenue): ?>
                            <tr>
                                <th scope="row"><?php echo substr($smonthlyrevenue['monthname'],0,3); ?></th>
                                <td><?php if($smonthlyrevenue['totalrevenue']!=0){echo $smonthlyrevenue['totalrevenue'];} ?></td>

                            </tr>
                        <?php endforeach; ?>

                       <!-- <tr>
                            <th scope="row">HTML/CSS</th>
                            <td>85</td>
                        </tr>
                        <tr>
                            <th scope="row">Bootstrap</th>
                            <td>880</td>
                        </tr>
                        <tr>
                            <th scope="row">JavaScript</th>
                            <td>700</td>
                        </tr>
                        <tr>
                            <th scope="row">AngularJS</th>
                            <td>60</td>
                        </tr>
                        <tr>
                            <th scope="row">jQuery</th>
                            <td>85</td>
                        </tr>
                        <tr>
                            <th scope="row">Ajax</th>
                            <td>60</td>
                        </tr>
                        <tr>
                            <th scope="row">PHP</th>
                            <td>50</td>
                        </tr>
                        <tr>
                            <th scope="row">MySQL</th>
                            <td>60</td>
                        </tr>
                        <tr>
                            <th scope="row">ITIL</th>
                            <td>90</td>
                        </tr>
                        <tr>
                            <th scope="row">Scrum</th>
                            <td>90</td>
                        </tr>
                        <tr>
                            <th scope="row">Custom</th>
                            <td>95</td>
                        </tr>-->

                        </tbody>
                    </table>
                </div>
            </div>
</section>

<div class="clear"></div>






          <!--new piechart code start-->



          <!--new piechart code end-->







            <!--pie chart code start-->
            <div class="rightdivwrapper rightdivwrapper2"><div class="box-header customer">
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

<!--
                <div id="specificChart" class="donut-size">
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


<div class="progresschart">

        <h2 class="progresshead"> </h2>

          <div id="chartContainer1" style="width: 98%; height: 300px;display: inline-block;"></div>
    </div>
          <script type="text/javascript">
              window.onload = function () {
                  var chart = new CanvasJS.Chart("chartContainer1", {
                      theme: "theme3",
                      title: {
                          text: "Progress Chart"
                      },
                      animationEnabled: true,
                      axisX: {
                          valueFormatString: "MMM",
                          interval: 1,
                          intervalType: "month"

                      },
                      axisY: {
                          includeZero: false

                      },
                      data: [{
                          type: "line",
                          //lineThickness: 3,
                          dataPoints: [
                              <?php $flag=0; foreach ($monthlyrevenue as $smonthlyrevenue): ?>
                              {x: new Date(2017, <?php echo $flag; ?>, 1), y: <?php echo $smonthlyrevenue['totalrevenue']; ?>},
<?php $flag++; endforeach; ?>
                              /*
                              {x: new Date(2017, 01, 1), y: 414},
                              {
                                  x: new Date(2017, 02, 1),
                                  y: 520,
                                  indexLabel: "highest",
                                  markerColor: "red",
                                  markerType: "triangle"
                              },
                              {x: new Date(2012, 03, 1), y: 460},
                              {x: new Date(2012, 04, 1), y: 450},
                              {x: new Date(2012, 05, 1), y: 500},
                              {x: new Date(2012, 06, 1), y: 480},
                              {x: new Date(2012, 07, 1), y: 480},
                              {
                                  x: new Date(2012, 08, 1),
                                  y: 410,
                                  indexLabel: "lowest",
                                  markerColor: "DarkSlateGrey",
                                  markerType: "cross"
                              },
                              {x: new Date(2012, 09, 1), y: 500},
                              {x: new Date(2012, 10, 1), y: 480},
                              {x: new Date(2012, 11, 1), y: 510}*/
                          ]
                      }
                      ]
                  });

                  chart.render();
              }
          </script>
          

      </div>
<!-- <div class="btns">
     <button id='update1'>57%
     </button>
     <button id='update2'>77%
     </button>
     <button id='update3'>100%
     </button>
 </div>-->






<!--new line chart code start-->


<!--new line chart code start-->




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