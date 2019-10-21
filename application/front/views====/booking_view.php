<?php
// echo "<pre>"; print_r($_SESSION);exit;
$this->load->view('templates/_include/header_view1'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
<style media="screen">
	.locate li{
		padding: 0px 30px;
	}
	.fav{
		color: #2e9494;
		font-size: 18px;
		cursor: pointer;
		float: right;
		margin-top: 64px;
		margin-left: 5px;
	}
	a:hover{
		text-decoration: none;
	}
</style>
<div class="container">
	<div class="past-booking">
		<h4 <?=($_GET['pab'] && $_GET['pab'] == 1) ? 'style="border-bottom:2px solid #337ab7;"':''?>><a href="<?php echo base_url()?>booking?pab=1" >Past Bookings (<?=$past_booking_data?>)</a></h4>&nbsp;&nbsp;<h4>|</h4>&nbsp;&nbsp;
		<h4 <?=($_GET['uab'] && $_GET['uab'] == 1) ? 'style="border-bottom:2px solid #337ab7;"':''?>><a href="<?php echo base_url()?>booking?uab=1">Upcoming Appointments (<?=$present_booking_data?>)</a></h4>&nbsp;&nbsp;<h4>|</h4>&nbsp;&nbsp;

    <h4 <?=($_GET['cab'] && $_GET['cab'] == 1) ? 'style="border-bottom:2px solid #337ab7;"':''?>><a href="<?php echo base_url()?>booking?cab=1">Complete Bookings (<?=$finished_booking_data?>)</a></h4>
	</div>
	<div class="cls_main_section" id="load_data">
  </div>
	<div class="col-md-12">
    <div id="load_data_message" style="text-align:center;"></div>
  </div>
</div>

<!-- Review model start -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Write Review</h4>
      </div>
       
      <div class="modal-body">
        <h3 class="modal-title">Worker Rating</h3>
        <hr> </hr>
            <input type="hidden" name="serviceData" id="serviceData" data-shop="" data-service="" data-appointment="" data-star="">
            <input type="hidden" name="serviceData1" id="serviceData1" data-shop="" data-service="" data-appointment="" data-star="">
            <input type="hidden" name="serviceData2" id="serviceData2" data-shop="" data-service="" data-appointment="" data-star="">
            <input type="hidden" name="serviceData3" id="serviceData3" data-shop="" data-service="" data-appointment="" data-star="">
            <input type="hidden" name="serviceData4" id="serviceData4" data-shop="" data-service="" data-appointment="" data-star="">
            <div class="form-group">
              <label class="control-label" style="margin-left:9px;">Worker</label><br>
                <label class="control-label" id="lbl_worker_name" style="border:1px solid #ccc;padding: 9px 15px;"></label>
            </div>
            <div class="form-group">
                <label for="add_review" class="control-label">Worker rating</label>
                <div class="star-container modelPopupStar">
                  <i class="fa fa-star fa-2x starSection" id="star-1" data-id="1"></i>
                  <i class="fa fa-star fa-2x starSection" id="star-2" data-id="2"></i>
                  <i class="fa fa-star fa-2x starSection" id="star-3" data-id="3"></i>
                  <i class="fa fa-star fa-2x starSection" id="star-4" data-id="4"></i>
                  <i class="fa fa-star fa-2x starSection" id="star-5" data-id="5"></i>
                </div>
            </div>
<hr> </hr>
 <h3 class="modal-title">Shop Rating</h3>
 <hr> </hr>
            <div class="form-group col-md-6">
                <label for="add_review" class="control-label">Service quality</label>
                <div class="star-container1 modelPopupStar">
                  <i class="fa fa-star fa-2x starSection1" id="star-11" data-id="1"></i>
                  <i class="fa fa-star fa-2x starSection1" id="star-21" data-id="2"></i>
                  <i class="fa fa-star fa-2x starSection1" id="star-31" data-id="3"></i>
                  <i class="fa fa-star fa-2x starSection1" id="star-41" data-id="4"></i>
                  <i class="fa fa-star fa-2x starSection1" id="star-51" data-id="5"></i>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="add_review" class="control-label">Cleanliness</label>
                <div class="star-container2 modelPopupStar">
                  <i class="fa fa-star fa-2x starSection2" id="star-12" data-id="1"></i>
                  <i class="fa fa-star fa-2x starSection2" id="star-22" data-id="2"></i>
                  <i class="fa fa-star fa-2x starSection2" id="star-32" data-id="3"></i>
                  <i class="fa fa-star fa-2x starSection2" id="star-42" data-id="4"></i>
                  <i class="fa fa-star fa-2x starSection2" id="star-52" data-id="5"></i>
                </div>
            </div>


            <div class="form-group col-md-6">
                <label for="add_review" class="control-label">Friendliness</label>
                <div class="star-container3 modelPopupStar">
                  <i class="fa fa-star fa-2x starSection3" id="star-13" data-id="1"></i>
                  <i class="fa fa-star fa-2x starSection3" id="star-23" data-id="2"></i>
                  <i class="fa fa-star fa-2x starSection3" id="star-33" data-id="3"></i>
                  <i class="fa fa-star fa-2x starSection3" id="star-43" data-id="4"></i>
                  <i class="fa fa-star fa-2x starSection3" id="star-53" data-id="5"></i>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="add_review" class="control-label">Value for money</label>
                <div class="star-container4 modelPopupStar">
                  <i class="fa fa-star fa-2x starSection4" id="star-14" data-id="1"></i>
                  <i class="fa fa-star fa-2x starSection4" id="star-24" data-id="2"></i>
                  <i class="fa fa-star fa-2x starSection4" id="star-34" data-id="3"></i>
                  <i class="fa fa-star fa-2x starSection4" id="star-44" data-id="4"></i>
                  <i class="fa fa-star fa-2x starSection4" id="star-54" data-id="5"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="add_review" class="control-label">Write your review</label>
                <div class="input-group">
                    <textarea class="form-control" rows="4" cols="50" id="add_review" name="add_review" type="text" value=""></textarea>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="SaveReview" data-dismiss="modal">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Review model End -->

<script type="text/javascript">
  var site_url = $("#site_url").val();
</script>

<script type="text/javascript">
<?php
if(empty($appointment_list)){?>
  $('.cls_near_view_more').hide();
  $('.cls_booking_title').hide();
<?php }?>

$(document).on('click', ".btn_call_us", function () {
  var data = $(this).attr('data-shop-mobile');
  var data1 = '<a href="tel:'+data+'" class="btn_call_us">'+data+'</a>'
  $(this).html(data1);
});

$(document).on('click', ".btn_cancel", function () {
  var appointment_id = $(this).attr('data-appointment-id');

  swal({
    title: "Are you sure?",
    text: "You want to cancel this appointment",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    closeOnConfirm: true,
    closeOnCancel: true
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
          type: 'POST',
          url: site_url+'booking/cancel_appointment',
          data:'appointment_id='+appointment_id,
          beforeSend: function () {
            $( ".cancel_ap"+appointment_id ).hide();
            $( ".cls_status").html('Canceled');
            // $("#overlay").show();
              // $('.loading').show();
          },
          success: function (data) {
            // $("#overlay").hide();
            $( ".cancel_ap"+appointment_id ).hide();
            $( ".cls_status").html('Canceled');
            location.reload(true);
            // swal("", "Your appointment has been cancelled", "success");
          }
      });
    } else {
      // swal("Cancelled", "image not deleted", "error");
    }
  });
});

$(document).on('click', ".btn_confirm", function () {
  var appointment_id = $(this).attr('data-appointment-id');

  swal({
    title: "Are you sure?",
    text: "You want to Confirm this appointment",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    closeOnConfirm: true,
    closeOnCancel: true
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
          type: 'POST',
          url: site_url+'booking/confirm_appointment',
          data:'appointment_id='+appointment_id,
          beforeSend: function () {
            $( ".confirm_ap"+appointment_id ).hide();
            $( ".cls_status").html('Canceled');
            // $("#overlay").show();
              // $('.loading').show();
          },
          success: function (data) {
            // $("#overlay").hide();
            $( ".confirm_ap"+appointment_id ).hide();
            $( ".cls_status").html('Canceled');
            location.reload(true);
            // swal("", "Your appointment has been cancelled", "success");
          }
      });
    } else {
      // swal("Cancelled", "image not deleted", "error");
    }
  });
});

$(".appoinemnt_slider").on("click", function() {
if($(".appoinemnt_slider").is(':checked')){
  <?php
  if(!empty($appointment_list)){?>
    $('.booking_block').show();
    $('.cls_near_view_more').show();
    $('.cls_booking_title').show();
    $('.cls_msg').html('');
  <?php }?>
}
else{
    $('.booking_block').hide();
    $('.cls_near_view_more').hide();
    $('.cls_booking_title').hide();
    <?php
    if(!empty($appointment_list)){?>
      var display_msg = '<div class="col-xs-12" style="padding-bottom:30px;text-align: center;"><h2>There is no data to display.</h2></div>';
      $('.cls_msg').html(display_msg);
    <?php }?>
}
});
 </script>

<script type="text/javascript">
$(document).ready(function(){

 var booking_limit = 4;
 var booking_start = 0;
 var booking_action = 'booking_inactive';
 var past_appointments = '<?=($_GET['pab'] && $_GET['pab'] = 1 ? $_GET['pab'] : '')?>';
 var current_appointments = '<?=($_GET['uab'] && $_GET['uab'] = 1 ? $_GET['uab'] : '')?>';
 var finished_appointments = '<?=($_GET['cab'] && $_GET['cab'] = 1 ? $_GET['cab'] : '')?>';
 // console.log(past_appointments+'-'+current_appointments);
 function load_country_data(booking_limit, booking_start, past_appointments, current_appointments , finished_appointments)
 {
  $.ajax({
   url:site_url+'booking/booking_data',
   method:"POST",
   data:{limit:booking_limit, start:booking_start, past_appointments:past_appointments, current_appointments:current_appointments, finished_appointments:finished_appointments},
   cache:false,
   success:function(data)
   {
		 // console.log(data);
    if($.trim(data) == '')
    {
       // $('#load_data_message').hide();
	     $('#load_data_message').html("<div class='row' style='clear:both;'><h2 style='text-align:center;'>You dont have any bookings so far or you are at the end of the page.</h2></div>");
	     booking_action = 'booking_active';
    }
    else
    {
      $('#load_data').append(data);
      var m_url = '<?php base_url()?>front/images/loader.gif';
     	$('#load_data_message').html("<img src="+m_url+">");
     	booking_action = "booking_inactive";
    }
   }
  });
 }

 if(booking_action == 'booking_inactive')
 {
  booking_action = 'booking_active';
  load_country_data(booking_limit, booking_start, past_appointments, current_appointments, finished_appointments);
 }
 $(window).scroll(function(){
  if($(window).scrollTop() + $(window).height() > $("#load_data").height() && booking_action == 'booking_inactive')
  {
   booking_action = 'booking_active';
   booking_start = booking_start + booking_limit;
   setTimeout(function(){
    load_country_data(booking_limit, booking_start, past_appointments, current_appointments, finished_appointments );
  }, 4000);
  }
 });

});
</script>
