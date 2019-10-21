$(document).ready(function(){
  var site_url = $("#site_url").val();
  // var site_url = document.location.origin;
  // var main_url = '/gggroom.git';

  var date = new Date();
  date.setDate(date.getDate()-1);
  $('.datetimepicker1').datetimepicker({
     format: 'DD-MM-YYYY',
     // defaultDate: new Date(),
      // minDate: new Date
      // minDate: date
  }).on('dp.change', function (e) {
    $('#start_time').val('');
   });

   $('.input-group-addon').on('click', function() {
    $(this).prev('.datetimepicker1').data('DateTimePicker').toggle();
   });

  $('#start_time').timepicker({
    'showDuration': true,
    'timeFormat': 'g:i A'
  });

  $(document).on('change', "#start_time", function () {

  var from_time = $('#start_time').val();
  var worker_date = $('#ap_date').val();
  var worker_id = $('#worker_id').val();
  var service_id = $('#service_id').val();
  var shop_id = $('#shop_id').val();
  var timeid = $('#service_time').val();
  var datastring = 'worker_id='+ worker_id + '&from_time=' + from_time + '&worker_date=' + worker_date + '&service_id=' + service_id + '&shop_id=' + shop_id + '&to_time=' + timeid ;

  $.ajax({
      url: site_url+"/appointment/get_worker_time_check",
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
              url: site_url+"appointment/check_worker_appointment_time",
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
});
