var site_url = $("#site_url").val();
$(document).ready(function(){
  $('#time').timepicker({
    'showDuration': true,
    'timeFormat': 'g:i A'
  });
  // $('#cls_view_time').timepicker({
  //   'showDuration': true,
  //   'timeFormat': 'g:i A'
  // });

  // $(function() {
        var date = new Date();
        date.setDate(date.getDate()-1);
        $('.datetimepicker1').datetimepicker({
           format: 'MM-DD-YYYY',
           defaultDate: new Date(),
            // minDate: new Date
            minDate: date
        }).on('dp.change', function (e) {
          $('#appoi_date').val($(this).val())
          $('.cls-chk').prop('checked', false);

         });
    $('.input-group-addon').on('click', function() {
     $(this).prev('.datetimepicker1').data('DateTimePicker').toggle();
    });



  // });
  // $('#datetimepicker1').datetimepicker({
  //     format: 'MM-DD-YYYY'
  // });

  //set your publishable key
  // Stripe.setPublishableKey('pk_test_BYHEtYct1FF7M8URDrDZkUGa');
   Stripe.setPublishableKey('pk_test_ajyjX25IOpFaCxbfsbLYdNGT');

  //on form submit
  /*$("#paymentFrm").submit(function(event) {

  });*/


  $("#card_number").mask("9999 9999 9999 9999", {
    placeholder: " "
  });
  $("#card_expiration").mask("99/9999", {
    placeholder: " "
  });
  $("#card_cvv").mask("999", {
    placeholder: " "
  });

  $('#time').on('change', function() {
    var shop_id = $('#shop_id').val();
    var start_date = $('.datetimepicker1').val();
    var start_time = $('#time').val();
    var datastring = 'start_date='+ start_date +'&shop_id=' + shop_id +'&start_time=' + start_time;

    $.ajax({
        url: site_url + "appointment/check_vacation_module_shop",
        type: 'post',
        data: datastring,
        success: function (data) {
           var data1 = JSON.parse(data);

           console.log(data1);
           if(data1 != 0){
             swal({
                   title: "",
                   text: "This shop is in vacation mode from "+data1[0].start_date+" -- "+data1[0].start_time+" to "+data1[0].end_date+" -- "+data1[0].end_time+", Please select another date & time",

               }, function () {
                 $('.datetimepicker1').val('');
                 $('#time').val('');
                 $('html, body').animate({
                         scrollTop: $('.cls_appointment').offset().top
                     }, 'slow');
               })
           }
        },
        error: function () {
        }
    });
  });

});


//callback to handle the response from stripe
function stripeResponseHandler(status, response) {
  if (response.error) {
      //enable the submit button
      $('#payBtn').removeAttr("disabled");
      //display the errors on the form
      $(".payment-errors").show();
      $("#name_card").val('');
      $("#card_number").val('');
      $("#card_expiration").val('');
      $("#card_cvv").val('');
      $(".payment-errors").html('<h2>'+response.error.message+'</h2>');
      $("#overlay").hide();
      return false;
  } else {
      // var form$ = $("#paymentFrm");
      //get token id
      var token = response['id'];
      //insert the token into the form
      $('.stripetoken').append("<input type='hidden' name='stripeToken' id='stripeToken' value='" + token + "' />");
      return true;
      //submit form to the server
      // form$.get(0).submit();
  }
}
