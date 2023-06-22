

<!doctype html>
<html lang="en">

<head>
    <title>Laravel 9 Fullcalandar Jquery Ajax Create and Delete Event </title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>
</head>


<div class="container-fluid">
    <div class="panel panel-primary ">
        <div class="panel-heading mt-4 pt-5">
            Events
        </div>
        <div class="panel-body">
            <div id='calendar'></div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next',
                center: 'title', // right: 'month,basicWeek,basicDay'
                right: 'month'
            },
            // navLinks: true,
            editable: true,
            events: "http://127.0.0.1:8000/admin/getEvent",
            displayEventTime: false,
            eventRender: function(event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay) {
                // $('#eventsModal').modal('toggle');
                var title = prompt('Event Title ');
                if (title) {
                    var start = moment(start, 'DD.MM.YYYY').format('YYYY-MM-DD');
                    var end = moment(end, 'DD.MM.YYYY').format('YYYY-MM-DD');

                    $.ajax({
                        url: "http://127.0.0.1:8000/admin/events",
                        data: "title=" + title + "&start=" + start + "&end=" + end +
                            '&_token=' +
                            "<?php echo e(csrf_token(), false); ?>",
                        type: "POST",
                        success: function(data) {
                            $('#calendar').fullCalendar('refetchEvents');
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            },
            eventClick: function(event) {
                var deleteMsg = confirm("Do you really want to delete?");
                if (deleteMsg) {
                    $.ajax({
                        type: "DELETE",
                        url: "http://127.0.0.1:8000/admin/events",
                        data: "id=" + event.id + '&_token=' + "<?php echo e(csrf_token(), false); ?>",
                        success: function(response) {
                            if (parseInt(response) > 0) {
                                $('#calendar').fullCalendar('removeEvents', event.id);
                            }
                        }
                    });
                }
            }
        });
    });
</script>

</html>
<?php /**PATH D:\wrok_in_ics\2023_06_09-school\resources\views/admin/events/index.blade.php ENDPATH**/ ?>