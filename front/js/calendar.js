$(document).ready(function() {
    var site_url = $("#site_url").val();
            /*$(".form_datetime").datetimepicker({
                format: 'hh:ii',
                autoclose: 1,
            });*/
            /*$('.form_datetime').datetimepicker({
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 1,
                minView: 0,
                maxView: 1,
                forceParse: 0
            });*/
            var tempevent = "";
            var startDate = "";
            var endDate = "";
            var eventsData=
                [
                    {
                        title: 'All Day Event',
                        start: '2018-03-01',
                    },
                    {
                        id: 132,
                        title: 'Long Event',
                        start: '2018-03-07',
                        end: '2018-03-10'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2018-03-09T16:00:00'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2018-03-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2018-03-11',
                        end: '2018-03-13',
                        color  : '#000'
                    },
                    {
                        title: 'Meeting',
                        start: '2018-03-12T10:30:00',
                        end: '2018-03-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2018-03-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2018-03-12T14:30:00'
                    },
                    {
                        title: 'Happy Hour',
                        start: '2018-03-12T17:30:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2018-03-12T20:00:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2018-03-12T20:00:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2018-03-12T20:00:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2018-03-12T20:00:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2018-03-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        // url: 'http://google.com/',
                        start: '2018-03-28'
                    }
                ];
            var NeweventsData= [
                    {
                      title: 'My Event',
                      start: '2018-03-27',
                      description: 'This is a cool event'
                    }
                    // more events here
                  ];
            $(".firstemployee").on("click", function() {  
                $('#calendar').fullCalendar('gotoDate', '2018-03-01' );
                $('#calendar').fullCalendar('removeEventSources');
                $('#calendar').fullCalendar('addEventSource', {
                    events: eventsData
                  });
            });
            $(".secondemployee").on("click", function() {   
                $('#calendar').fullCalendar('gotoDate', '2018-03-01' );
                $('#calendar').fullCalendar('removeEventSources');
                $('#calendar').fullCalendar('addEventSource', {
                    events: NeweventsData
                  });
            });

            $(".thirdemployee").on("click", function() { 
                $('#calendar').fullCalendar('gotoDate', '2018-10-01' );
                $('#calendar').fullCalendar('removeEventSources');
                $('#calendar').fullCalendar('addEventSource', {
                    events: [{
                      title: 'Event 1',
                      start: '2018-10-01'
                    },
                    {
                      title: 'Event 2',
                      start: '2018-10-02'
                    }]
                  });
            });

            $(document).on('click', ".WorkerData", function () {
                var workerid = $(this).attr('data-id');
                var form_data = [{"name": "workerid","value": workerid}];
                $.ajax({
                    url: site_url + 'calendar/GetWorkerAppointmentsData',
                    type: "POST",
                    data: form_data,
                    success: function(data) {
                        // console.log(data);return false;
                        var obj = JSON.parse(data);
                        $('#calendar').fullCalendar('removeEventSources');
                        $('#calendar').fullCalendar('addEventSource', {
                            events: obj
                        });
                    }
                });
            });

            $(".getallevents").on("click", function() { 
                var test = $('#calendar').fullCalendar('clientEvents'); // get all calender events
                console.log('test',test);
            });


            /*$('#calendar').fullCalendar('gotoDate', '2018-02-12' ); // Go to any date
            var test = $('#calendar').fullCalendar('clientEvents'); // get all calender events
            console.log('test',test);
            $('#calendar').fullCalendar( ‘clientEvents’ [, idOrFilter/Array ] ) // get only perticular clients event
            $('#calendar').fullCalendar('removeEventSource', eventData, true); // perticular event remove
            $('#calendar').fullCalendar('removeEventSources');  // whole data blank
            $('#calendar').fullCalendar('destroy');  // whole calender destroy
            $('#calendar').fullCalendar('removeEvents',12);  // remove event based on id*/



            $("#myModal").on("hidden.bs.modal", function () {
                if(tempevent)
                {
                    var title = $("#event_title").val();
                    tempevent.title = title;
                    $('#calendar').fullCalendar('updateEvent', tempevent);
                    tempevent = "";
                }
                else
                {
                    var title = $("#event_title").val();
                    var start = startDate;
                    var end = endDate;
                    var eventData;
                    if (title) {
                      eventData = {
                        title: title,
                        start: start,
                        end: end
                      };
                      $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                    }
                    startDate = "";
                    endDate = "";
                    $('#calendar').fullCalendar('unselect');
                }
                tempevent = "";
            });
            $('.prev-button').click(function() {
              $('#calendar').fullCalendar('prev');
            });
            $('.next-button').click(function() {
              $('#calendar').fullCalendar('next');
            });
            $('.today-button').click(function() {
              $('#calendar').fullCalendar('today');
            });
            $('#selected_view').change(function() {
                var selected_view = $(this).val();
                $('#calendar').fullCalendar('changeView', selected_view);
            });

            var d = new Date();

            var month = d.getMonth()+1;
            var day = d.getDate();

            var output = d.getFullYear() + '-' +
                ((''+month).length<2 ? '0' : '') + month + '-' +
                ((''+day).length<2 ? '0' : '') + day;
            $('#calendar').fullCalendar({
                header: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                defaultDate: output,
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    console.log('start',moment(start).format());
                    console.log('end',moment(end).format());
                    startDate = start;
                    endDate = end;
                    $("#event_title").val("");
                    // $('#myModal').modal('show');
                },
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                /*eventRender: function(event, element, view) {
                    if (view.name == 'listDay') {
                        element.find(".fc-list-item-time").append("<span class='closeon'>x</span>");
                    } else {
                        element.find(".fc-content").prepend("<span class='closeon'>x</span>");
                    }
                    element.find(".closeon").on('click', function() {
                        $('#calendar').fullCalendar('removeEvents',event._id);
                        console.log('delete');
                    });
                },*/
                eventColor: '#299494',
                eventTextColor: '#FFF',
                eventClick: function(event, element) {
                    tempevent = event;
                    $("#event_title").val("");
                    $("#event_title").val(event.title);
                    // $('#myModal').modal('show');
                    // event.title = "CLICKED!";
                    // $('#calendar').fullCalendar('updateEvent', event);
                },
                /*dayRender: function (date, cell) {
                    cell.css("background-color", "red");
                },
                defaultView: 'month', //agendaDay //month //agendaWeek
                weekends: false,
                eventBorderColor: 'red',*/
            });
});
var firstcat = null;
var secondcat = null;
var thirdcat = null;
$(document).on('click', ".btn-group-maincat > button.btn", function (event) {
    firstcat = this.innerHTML;
    $(".btn-group-maincat > button.btn").removeClass("active");
    $(".category_tree .firstcat").html(firstcat + " > ");
});
// var ds = "Mon Jul 03 2017 00:00:00 GMT+0530 (India Standard Time)";
// var date = moment(new Date(ds.substr(0, 16)));
// console.log('date',date.format("YYYY-MM-DD"));
$("#AllshopDropDown").change(function(event) {
    $("#overlay").show();
    var form_data = [{"name": "shopid","value": $(this).val()}];
    $.ajax({
        url: site_url + 'calendar/GetShopWorkerData',
        type: "POST",
        data: form_data,
        success: function(data) {
            // console.log(data); 
            // return false;
            $("#overlay").hide();
            $(".WorkerDiv").html(data);
        }
    });
});