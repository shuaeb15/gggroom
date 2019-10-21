$(document).ready(function($){
var site_url = $("#site_url").val();
  $('#datepairExample1 .time').timepicker({
      'showDuration': true,
      'timeFormat': 'g:i A',
      /*'disableTimeRanges': [
          ['1am', '10am'],
          ['3am', '4:01am']
      ]*/
  });
  $('#datepairExample1').datepair();

        $("#Monday1").focusout(function(){
          if($("#Monday1").val() != '' && $("#Monday2").val() != ''){
            if($("#Monday1").val() == $("#Monday2").val())
            {
              console.log('if_monday1');
              setTimeout(function(){
                swal("", "You can't select less time, Please select another time.");
                $("#Monday1").val('');
              }, 500);
            }
          }
      });

        $("#Monday2").focusout(function(){
          if($("#Monday1").val() != '' && $("#Monday2").val() != ''){
            if($("#Monday1").val() == $("#Monday2").val())
            {
              setTimeout(function(){
                swal("", "You can't select less time, Please select another time.");
                $("#Monday2").val('');
              }, 500);
            }
        }
      });

      if($("#Monday1").val() != '' || $("#Monday2").val() != ''){
        if(!$('input[name=radiog_list]:checked').length > 0){
          $('#Monday1').val('');
          $('#Monday2').val('');
          $('#break_Monday1').val('');
          $('#break_Monday2').val('');
          swal({
                title: "",
                text: "Please first select shop",

            }, function () {
              $('html, body').animate({
                      scrollTop: $('.cls_shop_detail').offset().top
                  }, 'slow');
            })
            return false;
        }
    }

      $('#datepairExample_breaks1 .time').timepicker({
          'showDuration': true,
          'timeFormat': 'g:i A'
      });
      $('#datepairExample_breaks1').datepair();

      $('#datepairExample1').on('changeTime', function() {
          $("#break_Monday1").val("");
          $("#break_Monday2").val("");
          $('#datepairExample_breaks1 .time').timepicker('option', 'minTime', $("#Monday1").val());
          $('#datepairExample_breaks1 .time').timepicker('option', 'maxTime', $("#Monday2").val());
      });

      $("#break_Monday1").focusout(function(){
        if($("#break_Monday1").val() != '' && $("#break_Monday2").val() != ''){
          if($("#break_Monday1").val() == $("#break_Monday2").val())
          {
            setTimeout(function(){
              swal("", "You can't select less time, Please select another time.");
              $("#break_Monday1").val('');
            }, 500);
          }
      }

      var starttime = $('#Monday1').val();
      var endtime = $('#Monday2').val();
      if(starttime == '' || endtime == ''){
        $('#break_Monday1').val('');
        $('#break_Monday2').val('');
        swal({
              title: "",
              text: "Please select business hours time",

          }, function () {
            $('html, body').animate({
                    scrollTop: $('.cls_business_hours').offset().top
                }, 'slow');
          })
          $('.img_business').attr('src',site_url+'../front/images/delete.png');
          return false;
      }
      });

      $("#break_Monday2").focusout(function(){
      if($("#break_Monday1").val() != '' && $("#break_Monday2").val() != ''){
        if($("#break_Monday1").val() == $("#break_Monday2").val())
        {
          setTimeout(function(){
            swal("", "You can't select less time, Please select another time.");
            $("#break_Monday2").val('');
          }, 500);
        }
      }

      var starttime = $('#Monday1').val();
      var endtime = $('#Monday2').val();
      if(starttime == '' || endtime == ''){
        $('#break_Monday1').val('');
        $('#break_Monday2').val('');
        swal({
              title: "",
              text: "Please select business hours time",

          }, function () {
            $('html, body').animate({
                    scrollTop: $('.cls_business_hours').offset().top
                }, 'slow');
          })
          $('.img_business').attr('src',site_url+'../front/images/delete.png');
          return false;
      }
      });


  $(document).on('click', ".edit_shop_btn", function () {
    if(!$('input[name=radiog_list_detail]:checked').length > 0){
      swal({
            title: "",
            text: "Please select shop",

        }, function () {
          $('html, body').animate({
                  scrollTop: $('.cls_shop_detail').offset().top
              }, 'slow');
        })
        return false;
    }
    if($("#edit_worker_check").val() == '1')
    {
      if($("#cls-day-time").is(':visible')){
        var starttime = $('#Monday1').val();
        var endtime = $('#Monday2').val();

        if(starttime != '' && endtime != ''){
          if($('.cls_all_service').is(':checked') == false){
          swal({
                title: "",
                text: "Please select business hours day",

            }, function () {
              $('html, body').animate({
                      scrollTop: $('.cls_business_hours').offset().top
                  }, 'slow');
            })
            $('.img_business').attr('src',site_url+'../front/images/delete.png');
            return false;
          }
        }
        else{
          if(starttime == '' || endtime == ''){
            swal({
                  title: "",
                  text: "Please select business hours time",

              }, function () {
                $('html, body').animate({
                        scrollTop: $('.cls_business_hours').offset().top
                    }, 'slow');
              })
              $('.img_business').attr('src',site_url+'../front/images/delete.png');
              return false;
          }
        }
      }
    }
    else
    {
        var starttime = $('#Monday1').val();
        var endtime = $('#Monday2').val();

        if(starttime != '' && endtime != ''){
          if($('.cls_all_service').is(':checked') == false){
            $("#cls-day-time").show();
          swal({
                title: "",
                text: "Please select business hours day",

            }, function () {
              $('html, body').animate({
                      scrollTop: $('.cls_business_hours').offset().top
                  }, 'slow');
            })
            $('.img_business').attr('src',site_url+'../front/images/delete.png');
            return false;
          }
        }
        else{
          if(starttime == '' || endtime == ''){
            $("#cls-day-time").show();
            swal({
                  title: "",
                  text: "Please select business hours time",

              }, function () {
                $('html, body').animate({
                        scrollTop: $('.cls_business_hours').offset().top
                    }, 'slow');
              })
              $('.img_business').attr('src',site_url+'../front/images/delete.png');
              return false;
          }
        }
    }

  });


  $(document).on('click', ".radiog_list", function () {
    if ($(this).prop("checked")) {
      $("#Monday1").val('');
      $("#Monday2").val('');
      var form_data = [{"name": "shopid","value": $(this).val()}];
      $.ajax({
          url: site_url + 'worker/CheckShopTime',
          type: "POST",
          data: form_data,
          success: function(data) {
              var test = data.split('||');
              var dayArr = JSON.parse(test[0]);

              $(".cls_all_service").each(function() {
                  var day = $(this).val();
                  if ($.inArray(day, dayArr)!='-1') {
                      // $(this).attr('disabled','disabled');
                      $(this).prop("checked", true);
                  } else {
                      $(this).attr('disabled','disabled');
                      $(this).prop("checked", false);
                      // $(this).attr('disabled','disabled');
                  }
              });
              $('#datepairExample1 .time').timepicker({
                'showDuration': true,
                'timeFormat': 'g:i A',
              });
              $('#datepairExample1 .time').timepicker('option', 'minTime', test[1]);
              $('#datepairExample1 .time').timepicker('option', 'maxTime', test[2]);
          }
      });

      var shop_id = [{"name": "shopid","value": $(this).val()}];
      $.ajax({
          url: site_url + 'worker/check_shop_hours_for_worker',
          type: "POST",
          data: shop_id,
          success: function(data) {
            var data_array = JSON.parse(data);
            // console.log(dayArr);
            var Blank_Arr = [];
            for (var i = 0; i < data_array.length; i++) {
              Blank_Arr.push(data_array[i].hours_day);
            }
            console.log(Blank_Arr);
            for (var j = 1; j <= 7; j++) {
              var get_day = $('#service_day'+j).val();
              var n = Blank_Arr.includes(get_day);
              if(n == false){
                $('#service_day'+j).prop("checked", false);
                document.getElementById("service_day"+j).disabled = true;
              }
              else{
                $('#service_day'+j).prop("checked", true);
                document.getElementById("service_day"+j).disabled = false;
              }
            }
          }
      });
    }
  });

  var shop_id = $('input[name=radiog_list_detail]:checked').val();

  var form_data = [{"name": "shopid","value": shop_id}];
  $.ajax({
      url: site_url + 'worker/CheckShopTime',
      type: "POST",
      data: form_data,
      success: function(data) {

          var test = data.split('||');
          console.log(test);
          var main_test = test[0];
          var dayArr = $.parseJSON(main_test)
          $(".cls_all_service").each(function() {
              var day = $(this).val();
              if ($.inArray(day, dayArr)!='-1') {
                  // $(this).attr('disabled','disabled');
                  $(this).prop("checked", true);
              } else {
                  $(this).attr('disabled','disabled');
                  $(this).prop("checked", false);
                  // $(this).attr('disabled','disabled');
              }
          });
          $('#datepairExample1 .time').timepicker({
            'showDuration': true,
            'timeFormat': 'g:i A',
          });
          $('#datepairExample1 .time').timepicker('option', 'minTime', test[1]);
          $('#datepairExample1 .time').timepicker('option', 'maxTime', test[2]);

          $('#datepairExample_breaks1 .time').timepicker({
            'showDuration': true,
            'timeFormat': 'g:i A',
          });
          $('#datepairExample_breaks1 .time').timepicker('option', 'minTime', test[1]);
          $('#datepairExample_breaks1 .time').timepicker('option', 'maxTime', test[2]);

      }
  });
});
