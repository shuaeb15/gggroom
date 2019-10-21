$(document).ready(function(){
  var site_url = $("#site_url").val();

  $('#datepairExample1 .time').timepicker({
      'showDuration': true,
      'timeFormat': 'g:i A'
  });
  $('#datepairExample1').datepair();

  $("#Monday1").focusout(function(){
    var state = $("#state").val();
    if(state == ''){
      swal({
            title: "",
            text: "Please first select state",
        }, function () {
          $("#Monday1").val('');
          $("#Monday2").val('');
          $('html, body').animate({
                  scrollTop: $('.cls_addline').offset().top
              }, 'slow');
        })
        return false;
    }else{
      if($("#Monday1").val() != '' && $("#Monday2").val() != ''){
        if($("#Monday1").val() == $("#Monday2").val())
        {
          setTimeout(function(){
            swal("", "You can't select less time, Please select another time.");
            $("#Monday1").val('');
          }, 500);
        }
      }
    }
  });

  $("#Monday2").focusout(function(){
    var state = $("#state").val();
    if(state == ''){
      swal({
            title: "",
            text: "Please first select state",
        }, function () {
          $("#Monday1").val('');
          $("#Monday2").val('');
          $('html, body').animate({
                  scrollTop: $('.cls_addline').offset().top
              }, 'slow');
        })
        return false;
    }else{
      if($("#Monday1").val() != '' && $("#Monday2").val() != ''){
        if($("#Monday1").val() == $("#Monday2").val())
        {
          setTimeout(function(){
            swal("", "You can't select less time, Please select another time.");
            $("#Monday2").val('');
          }, 500);
        }
    }
    }
});

$(document).on('click', ".edit_shop_btn", function () {
  if($("#edit_shop_check").val() == '1')
  {
    if($("#cls-day-time").is(':visible')){

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

$("#city").autocomplete({
      source: function( request, response ) {
          $.ajax( {
              url: site_url + 'shop/Get_city_Data',
              type: "POST",
              dataType: "json",
              data: {
              term: request.term,
              },
              success: function( data ) {
                  response( data );
              }
          } );
      }
  });
});
