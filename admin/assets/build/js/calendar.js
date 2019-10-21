$(document).ready(function() {
  var site_url = $("#site_url").val();
  $(document).on('click', ".WorkerData", function () {
      var workerid = $(this).attr('data-id');
      var shop_id = $(this).attr('data-shop-id');

      var form_data = [{"name": "workerid","value": workerid},{"name": "shop_id","value": shop_id}];
      $.ajax({
          url: site_url + 'calendar/GetWorkerAppointmentsData',
          type: "POST",
          data: form_data,
          success: function(data) {
              // console.log(data);return false;
              var obj = JSON.parse(data);
              console.log(obj);
              $('#calendar').fullCalendar('removeEventSources');
              $('#calendar').fullCalendar('addEventSource', {
                  events: obj
              });
          }
      });
  });

  $("#AllshopDropDown").change(function(event) {
    $('#calendar').fullCalendar('removeEventSources');
      $("#overlay").show();
      var form_data = [{"name": "shopid","value": $(this).val()}];
      $.ajax({
          url: site_url + 'calendar/GetShopWorkerData',
          type: "POST",
          data: form_data,
          success: function(data) {
            var data1 = JSON.parse(data);
            console.log(data1[0]);
              $('#calendar').fullCalendar('removeEventSources');
              $('#calendar').fullCalendar('addEventSource', {
                  events: data1[0]
              });
              $(".WorkerDiv").html(data1[1]);
          }
      });
  });

  var form_data = [{"name": "shopid","value": $(this).val()}];

  $.ajax({
      url: site_url + 'calendar/GetShopWorkerData',
      type: "POST",
      data: form_data,
      success: function(data) {
        var data1 = JSON.parse(data);
        console.log(data1[0]);
          $('#calendar').fullCalendar('removeEventSources');
          $('#calendar').fullCalendar('addEventSource', {
              events: data1[0]
          });
          $(".WorkerDiv").html(data1[1]);
      }
  });

  var date = new Date();
  date.setDate(date.getDate()-1);
  $('.datetimepicker1').datetimepicker({
     format: 'DD-MM-YYYY',
     // defaultDate: new Date(),
      // minDate: new Date
      // minDate: date
  });

   $('.input-group-addon').on('click', function() {
    $(this).prev('.datetimepicker1').data('DateTimePicker').toggle();
   });

  $('#start_time').timepicker({
    'showDuration': true,
    'timeFormat': 'g:i A'
  });

  $(document).on('change', "#start_time", function () {
  var ap_id = $('#appointment_id').val();
  var ap_date = $('#ap_date').val();
  var from_time = $('#start_time').val();

  var datastring = 'ap_id='+ ap_id + '&from_time=' + from_time + '&ap_date=' + ap_date;

  $.ajax({
      url: site_url+"calendar/get_worker_time_check",
      type: 'post',
      data: datastring,
      success: function (data) {
        console.log(data);
        if(data != 1){
          var data_arry =  JSON.parse(data);
          $('#start_time').val('');
          var all_data = '';
          all_data += '<h2 style="font-size: 25px;">Worker not available</h2><br><h4>Worker available time<h4><hr>';
          for (var i = 0; i < data_arry.length; i++) {
            var from_time = moment(data_arry[i].from_time, "hh:mm:ss").format('LT');
            var to_time = moment(data_arry[i].to_time, "hh:mm:ss").format('LT')
            all_data += '<label>'+data_arry[i].worker_day+':    '+from_time+' - '+to_time+'</label><br>';
        }
        swal({
          title: all_data,
          html: "Testno  sporocilo za objekt: <b>test</b>",
          confirmButtonText: "",

          }, function () {

          })
        }
        else{
          $.ajax({
              url: site_url+"calendar/check_worker_appointment_time",
              type: 'post',
              data: datastring,
              success: function (data) {
                console.log($.trim(data));
                if($.trim(data) == 1){
                  swal({
                    title: "",
                    text: "Appointment already booked",
                   }, function () {
                      $('#start_time').val('');
                   })
                }
              },
          });
        }
      },
    });
  });

  $(document).on('click', ".edit_ap_btn", function () {

  var price = $('#ap_date').val();
  if(price == ''){
    swal({
          title: "",
          text: "Please select date",

      }, function () {
        return false;
        $('html, body').animate({
                // scrollTop: $('.cls_appointment').offset().top
            }, 'slow');
      })
      return false;
  }

  var main_time = $('#start_time').val();
  if(main_time == ''){
    swal({
          title: "",
          text: "Please select time",

      }, function () {
        return false;
        $('html, body').animate({
                // scrollTop: $('.cls_appointment').offset().top
            }, 'slow');
      })
      return false;
  }
  });

  $(document).on('click', ".delete_btn", function (e) {
  var appointment_id = $('#appointment_id').val();

  swal({
    title: "Are you sure?",
    text: "You want to delete this appointment",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    closeOnConfirm: true,
    closeOnCancel: true
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
          url: site_url + 'calendar/delete_appointment',
          method: "POST",
          data: {id: appointment_id},
          async: false,
          success: function (data) {
              var obj = JSON.parse(data);
              $('#myModal').modal('hide');
              if (obj.success == 'success') {
                  $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Appointment deleted successfully.</div>');
              }
              else if (obj.unsuccess == 'unsuccess') {
                  $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');
                }
          }
      });
    }
  });
  });
});
