<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$baseUrl = $this->config->item('base_url');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Claendar
            <small>Fees Paid</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $baseUrl; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $baseUrl; ?>calendar">Claendar</a></li>
            <li class="active">Fees Claendar</li>
        </ol>
    </section>

    <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="box box-warning">
              <div class="chartfilters">
                  <form method="post" action="" autocomplete="off">  
                  <div class=" col-sm-4">
                        <input type="text" class="form-control datepicker" value="<?php if(isset($_POST['date']) && !empty($_POST['date'])){ echo $_POST['date']; } ?>" id="startdateprofitlossfilt3" name="date" placeholder="Please Select Date">
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="date_btns btn btn-info filterchartcustombtn" id="submtfiltprofitloss3">Submit</button>
                    </div>
                  </form>
                </div>
            <div class="box-body no-padding">
              <div id="calendar"></div>
            </div>
          </div>
        </div>
    </div>
</section>
</div>




<script>
    $( document ).ready(function() {
    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
       
        var myevents2=<?php echo json_encode($fees_detail); ?>;
        
    var date = new Date('<?php echo $date; ?>');
//        var date=new Date();
        console.log(date);
//        console.log(date2);
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    window.initializecalendar=function(){
        
    }
    var moment1 = moment('2013-09-02');
var moment2 = moment('2013-09-09');
$.fullCalendar.formatRange(moment1, moment2, 'MMMM D YYYY');
    $('#calendar').fullCalendar({
        
      eventLimit: true,
      defaultDate: '<?php echo $date; ?>',
        
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
      events    : myevents2,
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
    });
    });

</script>
