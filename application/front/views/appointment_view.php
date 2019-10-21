<?php $this->load->view('templates/_include/header_view1'); ?>

<style media="screen">
.container {
max-width: 100%;
}
.aero1 img {
width: 2% !important;
position: relative !important;
float: left !important;
margin-top: -136px !important;
left: -12px !important;
}
.sq-input{
height: 30px !important;
padding:3px !important;
font-family: 'Roboto', sans-serif !important;
}
.sq-input input[type=text]{
padding:3px !important;
font-family: 'Roboto', sans-serif !important;
}
.AVAST_PAM_nonloginform input[type=text]{
padding:3px !important;
font-family: 'Roboto', sans-serif !important;
}

/* .cls_carousel_image{
width:100%;
height:130px;
object-fit: cover;
} */
/* .cls_item_img{
width:100%;
height:337px !important;
} */
/* .nav_btn {
margin-top: -26px;
} */
@media only screen and (max-width:480px){
.cls_card_payment{
width: 100%;
}
label.css-label-check {
float: left;
margin-bottom: 30px;
}
.cls_apply_btn{
margin-left: 11px;
}
.cls_item_img{
height:auto !important;
}
.nav_btn {
margin-bottom: 150px;
margin-top: -165px !important;
}
.customPrevBtn{
margin-left: 0px;
}
.customNextBtn{
margin-right: 0px;
}
.aero1 img {
width: 9%;
}
.aero img {
width: 9%;
}
.cls_cancellation p{
text-align: center;
padding-top: 0px;
}
.leftbox2{
width: 98% !important;
}
.cls_other_star{
width: 100%;
margin-top: 14px;
margin-left: 142px;
float: none !important;
}

}
</style>
<div class="multistepform">
<span class="form-title">Appointment Scheduler</span>
<div class="container">
<div id="app">
<step-navigation :steps="steps" :currentstep="currentstep">
</step-navigation>
<div v-show="currentstep == 1">
<div class="service_slider_main">
<div class="container">
<div class="service_slider service_div_sec">
<div class="owl-carousel owl-theme service_carousel">
<?php
$p = '9';

//echo '<pre>';print_r($servicelist);
foreach ($servicelist as $key => $service) {
$img = $service->image;
$temp_file = base_url()."front/images/banner.jpg";
$main_file = "assets/uploads/service_image/".$img;
$filename = FCPATH.$main_file;
if (file_exists($filename)) {
if($img != ''){
$main_image =  base_url().$main_file;
}else{
$main_image =  $temp_file;
}
}else{
$main_image =  $temp_file;
}

if(!empty($service->und_sub_category->cat_name)){
$category = $service->und_sub_category->cat_name.' - ' .$service->sub_category->cat_name;
$main_cat = $service->service_name;
}else if(!empty($service->sub_category->cat_name)){
$category = $service->sub_category->cat_name;
$main_cat = $service->service_name;
}else{
$category = $service->service_name;
$main_cat = '';
}
$p++;?>
<div class="col-md-6 leftbox2" style="width:95% !important;">
<div class="col-md-5">
<a href="<?=site_url()?>detail/shop_detail/<?=$service->encrypt_id?>/<?=$service->shop_id?>/<?=$service->encrypt_id?>">
<img src="<?=$main_image?>" class="img-responsive" style="width:100%;height:150px;display: inline;">
</a>
</div>
<div class="col-md-7">
<div class="cls_other_star" style="float: right;">
<?php for($i=0; $i < 5; $i++){?>
<?php if($i < $service->ratingRound){?>
<span class="fa fa-star checked" id="star-<?=$i?>"></span>
<?php }else{ ?>
<span class="fa fa-star" id="star-<?=$i?>"></span>
<?php }?>
<?php }?>
</div>
<h3 style="color:#049597; margin-top: 25px;"><?=$category?></h3>
<p style="padding-top: 3px"><?=$main_cat?> <br><?=$service->shop_name?></p>
<h2 style="margin-bottom: 0px; margin-top: 0px;color:#049597">$<?=$service->price?></h2>
<div class="radio_list_item">
<input type="checkbox" name="radiog_list" id="radio<?=$p?>" class="css-checkbox cls-chk-service" <?php if($service->id == $select_service_id){ echo 'checked';}?> value="<?=$service->id?>">
<label for="radio<?=$p?>" class="css-label css-label-check"></label>
</div>
</div>
</div>
<?php }?>
</div>
<div class="nav_btn">
<div class="customPrevBtn service_carousel_customPrevBtn">
<span class="aero1"><img src="<?php echo base_url('front/images2/left.png');?>" alt="Button prev"></span>
</div>
<div class="customNextBtn service_carousel_customNextBtn">
<span class="aero"><img src="<?php echo base_url('front/images2/right.png');?>" alt="Button next"></span>
</div>
</div>
</div>
</div>
</div>
</div>
<div v-show="currentstep == 2">
<div class="service_slider_main">
<div class="container">
<div class="cls_services">
</div>
<!-- <div class="form-group">
<label>SELECT DATE <span class="cls_star">*</span></label>
<div class='input-group date' id='datetimepicker2'>
<input type='text' id="appoi_date" class="form-control datetimepicker2" value="" style="cursor:pointer;width: 107% !important;" />
<span class="input-group-addon" style="cursor:pointer;">
<span class="fa fa-caret-down"></span>
</span>
</div>
</div> -->
<!-- <div class="col-md-12 rightside">
<div class="heading">
<b>Your Appointment With Spin and Tip Beauty Saloon</b>
</div>
<div class="scheduling-header">
<h3 style="color:#049597; margin-top: 25px;">MESSAGE AND SPA</h3>
<p class="price">$50</p><p class="add">ADD</p>
</div>
<div class="month">
<ul>
<li class="prev">&#10094;</li>
<li class="next">&#10095;</li>
<li>March<br><span style="font-size:18px">2019</span></li>
</ul>
</div>
<ul class="weekdays">
<li>Mo</li>
<li>Tu</li>
<li>We</li>
<li>Th</li>
<li>Fr</li>
<li>Sa</li>
<li>Su</li>
</ul>
<ul class="days">
<li>1</li>
<li>2</li>
<li>3</li>
<li>4</li>
<li>5</li>
<li>6</li>
<li>7</li>
<li>8</li>
<li>9</li>
<li><span class="active">10</span></li>
<li>11</li>
<li>12</li>
<li>13</li>
<li>14</li>
<li>15</li>
<li>16</li>
<li>17</li>
<li>18</li>
<li>19</li>
<li>20</li>
<li>21</li>
<li>22</li>
<li>23</li>
<li>24</li>
<li>25</li>
<li>26</li>
<li>27</li>
<li>28</li>
<li>29</li>
<li>30</li>
<li>31</li>
</ul>
<div class="timing">
<h4>Morning</h4><br>
<div style="margin-left: -10px;border-bottom: 1px solid #c2c2c2">
<ul>
<li><div class="timing-date">09:00AM</div></li>
<li><div class="timing-date">10:00AM</div></li>
<li><div class="timing-date">11:00AM</div></li>
<li><div class="timing-date">11:20AM</div></li>
<li><div class="timing-date">11:30AM</div></li>
</ul>
</div>
</div>
<div class="timing">
<div>
<h4>Evening</h4><br></div>
<div style="margin-left: -10px;border-bottom: 1px solid #c2c2c2">
<ul>
<li><div class="timing-date">07:00PM</div></li>
<li><div class="timing-date">08:00PM</div></li>
<li><div class="timing-date">09:00PM</div></li>
<li><div class="timing-date">10:00PM</div></li>
<li><div class="timing-date">11:00PM</div></li>
</ul>
</div>
<div class="pick_date">
VIEW MORE DATES
</div>
<div style="margin-left: -10px;border-bottom: 1px solid #c2c2c2">
<form>
<input type="hidden" name="shop_id" id="shop_id" value="<?=$servicelist[0]->shop_id?>">
<div class="form_date_time">
<div class="col-md-12 col-xs-12 nopadding subsec cls_nopadding">
<div class="col-md-6 col-xs-12">
<div class="form-group">
<label>SELECT DATE <span class="cls_star">*</span></label>
<div class='input-group date' id='datetimepicker1'>
<input type='text' id="appoi_date" class="form-control datetimepicker1" value="" style="cursor:pointer;"/>
<span class="input-group-addon" style="cursor:pointer;">
<span class="fa fa-caret-down"></span>
</span>
</div>
</div>
</div>
</div>
<div class="col-md-12 col-xs-12 subsec">
<label>SELECT TIME <span class="cls_star">*</span></label>
<div class='input-group' id='cls_view_time' style="width: 49%;">
<input type='text' id="time" class="form-control" value="09:00am" style="cursor:pointer;"/>
</span>
</div>
</div>
<input type='hidden' id="array_worker_data" class="form-control"/>
<div class="col-md-12 col-xs-12 subsec cls-subsec">
</div>
<div class="col-md-12 col-xs-12">
<div class="note">
<a href="#"><img src="<?=base_url()?>front/images/note.png"> Leave Note</a>
</div>
<textarea name="name" rows="8" cols="80" class="form-control" id="leave_note"  placeholder="Note"></textarea>
</div>
</div>
</form>
</div>
</div>
</div> -->
<div class="col-md-6 leftbox2 cls-subsec cls_date_time cls_appointment">
<form>
<div class="form_date_time">
<div class="col-md-12 col-xs-12 nopadding subsec cls_nopadding">
<div class="col-md-7 col-xs-12">
<div class="form-group">
<label>SELECT DATE <span class="cls_star">*</span></label>
<div class='input-group date' id='datetimepicker1'>
<input type='text' id="appoi_date" class="form-control datetimepicker1" value="" style="cursor:pointer;width: 107% !important;color: #000 !important;" />
<!-- <span class="input-group-addon" style="cursor:pointer;">
<span class="fa fa-caret-down"></span>
</span> -->
</div>
</div>
</div>
</div>
<div class="col-md-12 col-xs-12 subsec">
<div class="col-md-7 col-xs-12">
<label>SELECT TIME <span class="cls_star">*</span></label>
<div class='input-group' id='cls_view_time' style="width: 100%;">
<input type='text' id="time" class="form-control" value="09:00am" style="cursor:pointer;color: #000 !important;"/>
</span>
</div>
</div>
</div>
</div>
</form>
</div>
<div class="col-md-6 leftbox2 cls-subsec cls_worker_data">
<input type='hidden' id="array_worker_data" class="form-control"/>

<input type="hidden" name="shop_id" id="shop_id" value="<?=$shop_id?>">
<div class="cls_worker_section">
</div>
<div class="note" style="padding: 10px 10px;">Leave Note</div> <textarea name="name" rows="8" cols="80" id="leave_note" placeholder="Note" class="form-control" style="margin-left: 8px;"></textarea>
</div>
</div>
</div>

</div>
<div v-show="currentstep == 3">
<div class="service_slider_main">
<div class="container">
<div class="cls_services1">
</div>
</div>
</div>
<div class="col-md-6 rightside">
<div class="heading-left">
<div>
<input type="checkbox" name="gift_chkbx" id="gift_chkbx" class="css-checkbox">
<label for="gift_chkbx" class="css-label css-label-check dayCB" style="margin-bottom: 21px;">Do you want to purchase this as a gift?</label>
</div>
</div>
<br>
<div class="col-md-12">
<div class="cls_email_send_msg"></div>
<div class="cls_promocode_msg"></div>
<div class="form-group cls_top_email">
<input type="text" name="gift_user_email" id="gift_user_email" placeholder="Enter email" class="form-control" style="width:78%; margin-top: 5px;color:#000 !important;">
<div class="buttons" id="btn_send" style="margin-left: 20px !important;cursor:pointer;">SEND</div>
<input type="text" name="promocode" id="promocode" placeholder="Enter Promocode" class="form-control" style="width:78%; margin-top: 5px;color:#000 !important;">
<div class="buttons" id="btn_promocode" style="margin-left: 20px !important;cursor:pointer;">APPLY</div>
<input type="hidden" name="discount_price" value="" id="discount_price">
<input type="hidden" name="all_services_list" value="" id="all_services_list">
</div>
<div class="col-md-12 cls_main_msg_promocode"></div>
</div>
</div>
<!-- <div class="col-md-12 col-xs-12" style="margin-bottom:20px;">
<div class="cls_email_send_msg"></div>
<div class="col-md-12 cls_top_email" style="margin-bottom: 30px;">
<div class="">
<input type="checkbox" name="gift_chkbx" id="gift_chkbx" class="css-checkbox">
<label for="gift_chkbx" class="css-label css-label-check dayCB" style="margin-bottom: 30px;">Do you want to purchase this as a gift?</label>
</div>
<div class="cls_gift_btn">
<div class="col-md-4">
<div class="form-group">
<input type="text" class="form-control" name="gift_user_email" id="gift_user_email" placeholder="Enter email">
</div>
</div>
<div class="col-md-2 cls_apply_btn">
<div class="form-group">
<a href="javascript:void(0)" class="btn btn-default full-width-btn emboss-btn" id="btn_send" style="width: 50%;margin-left: -10px;">Send</a>
</div>
</div>
</div>
</div>
<div class="col-md-12">
<div class="cls_promocode_msg"></div>
</div>
<div class="col-md-12">
<div class="col-md-2">
<div class="form-group">
<input type="text" class="form-control" name="promocode" id="promocode" placeholder="Enter promocode">
</div>
</div>
<div class="col-md-2 cls_apply_btn">
<input type="hidden" name="discount_price" value="" id="discount_price">
<input type="hidden" name="all_services_list" value="" id="all_services_list">
<div class="form-group">
<a href="javascript:void(0)" class="btn btn-default full-width-btn emboss-btn" id="btn_promocode" style="width: 50%;margin-left: -10px;">Apply</a>
</div>
</div>
</div>
<div class="col-md-5 cls_main_msg_promocode"></div>
</div> -->
<div class="col-md-12 col-md-offset-0 midbox" >
<div class="heading">
<b>Select your payment method</b>
</div>
<div class="scheduling-header">
<h3 style="color:#049597; margin-top: 25px;text-align: center;" class="cls_service_price"></h3>
</div>
<div class="col-md-12 method">
<ul style="display: flex;" class="cls_ul">
<!-- <li><input type="checkbox" name="gift_chkbx" id="gift_chkbx1" checked="checked" class="css-checkbox"> <label for="gift_chkbx1" class="css-label css-label-check dayCB" style="margin-bottom: 21px;">DEBIT/CREDIT-CARD</label></li> -->
<li><input type="radio" name="payment_option" id="radio4" class="css-checkbox paymentRadio" checked value="1"> <label for="radio4" class="css-label css-label-check radGroup1 radGroup2" style="margin-bottom: 21px;">STRIPE</label></li>
<li><input type="radio" name="payment_option" id="radio5" class="css-checkbox paymentRadio" value="2"> <label for="radio5" class="css-label css-label-check radGroup1 radGroup2" style="margin-bottom: 21px;">SQUARE</label></li>
<!-- <li><input type="checkbox" name="gift_chkbx" id="gift_chkbx4" class="css-checkbox"> <label for="gift_chkbx4" class="css-label css-label-check dayCB" style="margin-bottom: 21px;">PAYPAL</label></li>
<li><input type="checkbox" name="gift_chkbx" id="gift_chkbx5" class="css-checkbox"> <label for="gift_chkbx5" class="css-label css-label-check dayCB" style="margin-bottom: 21px;">APPLEPAY</label></li>
<li><input type="checkbox" name="gift_chkbx" id="gift_chkbx6" class="css-checkbox"> <label for="gift_chkbx6" class="css-label css-label-check dayCB" style="margin-bottom: 21px;">VENMO</label></li> -->
<!-- <li><input type="radio" name="payment_option" id="radio6" class="css-checkbox paymentRadio" value="3"> <label for="radio6" class="css-label css-label-check radGroup1 radGroup2" style="margin-bottom: 21px;">CASH</label></li> -->
</ul>
</div>
<div class="col-md-12 col-xs-12 payment-errors" style="color:red;padding-bottom: 20px;text-align: center;display: none;"></div>
<div class="col-md-12 col-xs-12 stripePay">
<div class="stripetoken"></div>
<input type="hidden" name="orderid" value="" id="orderid">
<input type="hidden" name="priceData" value="0" id="priceData">
<div class="col-md-5 col-xs-5 col-md-offset-3 cls_card_payment">
<div class="form-group">
<label for="name_card">Name On Card <span class="cls_star">*</span></label>
<input type="text" class="form-control" name="name_card" id="name_card" placeholder="Enter Full Name" style="color:#000 !important;">
</div>
</div>
<div class="col-md-5 col-xs-5 col-md-offset-3 cls_card_payment">
<div class="form-group">
<label for="card_number">Card Number <span class="cls_star">*</span></label>
<input type="text" class="form-control" name="card_number" id="card_number" placeholder="9999 9999 9999 9999" style="color:#000 !important;">
</div>
</div>
<div class="col-md-5 col-xs-5 col-md-offset-3 cls_card_payment">
<div class="form-group">
<label for="card_expiration">Expiration <span class="cls_star">*</span></label>
<input type="text" class="form-control" name="card_expiration" id="card_expiration" placeholder="99/9999" style="color:#000 !important;">
</div>
</div>
<div class="col-md-5 col-xs-5 col-md-offset-3 cls_card_payment">
<div class="form-group">
<label for="card_cvv">CVV <span class="cls_star">*</span></label>
<input type="text" class="form-control" name="card_cvv" id="card_cvv" placeholder="123" style="color:#000 !important;">
</div>
</div>
</div>
<div class="col-md-12 col-xs-12 squreupPay">
<div id="squreupFrom" class="col-md-5 col-xs-5 col-md-offset-3 cls_card_payment" style="display: none;">
<div id="error"></div>
<div id="sq-card-number"></div>
<div class="third">
<div id="sq-expiration-date"></div>
</div>
<div class="third">
<div id="sq-cvv"></div>
</div>
<div class="third">
<div id="sq-postal-code"></div>
</div>
<input type="hidden" id="card-nonce" name="nonce">
</div>
</div>
</div>
</div>
<div v-show="currentstep == 4">
<div class="col-md-12 col-xs-12 payment_message" style="padding-bottom: 20px;text-align: center;margin-top:20px;">
</div>
<div class="col-md-12 col-xs-12">
<div class="col-md-4 col-md-offset-4 step-wrapper active" style="padding-top: 30px;">
<div class="button_list">
<a href="<?php echo base_url(); ?>">Done</a>
</div>
</div>
</div>
</div>
<step v-for="step in steps" :currentstep="currentstep" :key="step.id" :step="step" :stepcount="steps.length" @step-change="stepChanged">
</step>
<script type="x-template" id="step-navigation-template">
<ol class="step-indicator">
<li v-for="step in steps" is="step-navigation-step" :key="step.id" :step="step" :currentstep="currentstep">
</li>
</ol>
</script>
<script type="x-template" id="step-navigation-step-template">
<li :class="indicatorclass">
<div class="step" v-text="step.id"></div>
<div class="caption hidden-xs hidden-sm"><h3 v-text="step.title"></h3><p v-text="step.subtitle"></p></div>
</li>
</script>
<script type="x-template" id="step-template">
<div class="col-md-4 col-md-offset-4 cls_ap_md4" style="padding-top: 30px;">
<div class="step-wrapper" :class="stepWrapperClass">
<button type="button" class="btn btn-primary" style="display:none;" @click="lastStep" :disabled="firststep" >
Back
</button>
<button type="button" class="btn btn-default full-width-btn emboss-btn btn_continue" @click="nextStep" :disabled="laststep" v-if="!laststep">
Continue
</button>
<button type="submit" class="btn btn-primary" style="display:none;" v-if="laststep">
Submit
</button>
</div>
</div>
</script>
</div>
</div>
</div>
<!-- <script src="https://momentjs.com/downloads/moment.js"></script> -->
<script type="text/javascript">
var site_url = $("#site_url").val();
var time = '<?php echo date("H:i");?>';
</script>

<script type="text/javascript">
var radioState;
$(document).on('click', ".cls-chk", function (e) {
if (radioState === this) {
this.checked = false;
radioState = null;
} else {
radioState = this;
}
});

// $(document).ready(function(){
//   $(function() {
//         $('.datetimepicker1').datetimepicker({
//            format: 'MM-DD-YYYY'
//         });
//     $('.input-group-addon').on('click', function() {
//      $(this).prev('.datetimepicker1').data('DateTimePicker').toggle();
//     });
//   });
// });

$(document).on('change', "#time", function () {
$('.cls-chk').prop('checked', false);
});
// function get_radio_value(val1){
// $('#radio111').change(function(){
function addMinutes(time, minsToAdd) {
function D(J){ return (J<10? '0':'') + J;};
var piece = time.split(':');
var mins = piece[0]*60 + +piece[1] + +minsToAdd;
return D(mins%(24*60)/60 | 0) + ':' + D(mins%60);
}

$(document).on('click', ".cls-chk", function () {
if($('.cls-chk').is(':checked')){
var worker_id = $(this).attr('data-image-id');
var service_id = $(this).attr('data-services-id');
var shop_id = $('#shop_id').val();
var data_radio = $(this).attr('data-radio-id');
var timeid = $(this).attr('data-time-id');
var from_time = $('#time').val();
var services_time = $(this).attr('data-time-id');
var to_time =  addMinutes(time, services_time);
var start_date = $('.datetimepicker1').val();

var worker_date = $('#appoi_date').val();
var datastring = 'worker_id='+ worker_id + '&from_time=' + from_time + '&worker_date=' + worker_date + '&service_id=' + service_id + '&shop_id=' + shop_id + '&to_time=' + timeid ;

var shop_datastring = 'from_time='+ from_time +'&shop_id=' + shop_id;
var worker_datastring = 'start_date='+ start_date +'&worker_id=' + worker_id +'&start_time=' + from_time;

$.ajax({
url: site_url + "appointment/check_vacation_module_worker",
type: 'post',
data: worker_datastring,
success: function (data) {
var data1 = JSON.parse(data);
console.log(data1);
if(data1 != 0){
swal({
title: "",
text: "This worker is in vacation mode from "+data1[0].start_date+" -- "+data1[0].start_time+" to "+data1[0].end_date+" -- "+data1[0].end_time+", Please select another date & time",

}, function () {
$('.datetimepicker1').val('');
$('#time').val('');
$('.cls-chk').prop('checked', false);
$('html, body').animate({
scrollTop: $('.cls_nopadding').offset().top
}, 'slow');
})
}else{
$.ajax({
url: "<?php echo base_url(); ?>appointment/check_shop_break_time",
type: 'post',
data: shop_datastring,
success: function (data) {
var data1 = JSON.parse(data);
console.log(data1);
if(data1 != 0){
swal({
title: "",
text: "Shop breaking time: "+data1[0].break_start_time+" to "+data1[0].break_end_time+", Please select another time",
}, function () {
$('#time').val('');
$('.cls-chk').prop('checked', false);
$('html, body').animate({
scrollTop: $('.cls_nopadding').offset().top
}, 'slow');
});
}else{
$.ajax({
url: "<?php echo base_url(); ?>appointment/get_worker_time_check",
type: 'post',
data: datastring,
success: function (data) {
// console.log(data.length);
if(data != 1){
var data_arry =  JSON.parse(data);
console.log(data_arry);

$('#'+data_radio).prop('checked', false);
var all_data = '';

if(data_arry.length == 0){
all_data += '<h2>Worker not available</h2>';
}else{
all_data += '<h2>Worker not available</h2><br><h4>Worker available time<h4><hr>';
for (var i = 0; i < data_arry.length; i++) {
var from_time = moment(data_arry[i].from_time, "hh:mm:ss").format('LT');
var to_time = moment(data_arry[i].to_time, "hh:mm:ss").format('LT');
all_data += '<label>'+data_arry[i].worker_day+':    '+from_time+' - '+to_time+'</label><br>';
}
}
swal({
title: all_data,
html: "Testno  sporocilo za objekt: <b>test</b>",
confirmButtonText: "",
}, function () {
});
}
else{
$.ajax({
url: "<?php echo base_url(); ?>appointment/check_worker_break_time",
type: 'post',
data: datastring,
success: function (data) {
var data1 = JSON.parse(data);
console.log(data1);
if(data1 != 0){
swal({
  title: "",
  text: "Worker breaking time: "+data1[0].from_time+" to "+data1[0].to_time+", Please select another time",
}, function () {
$('#time').val('');
$('.cls-chk').prop('checked', false);
$('html, body').animate({
  scrollTop: $('.cls_nopadding').offset().top
}, 'slow');
});
}else{
$.ajax({
url: "<?php echo base_url(); ?>appointment/check_worker_appointment_time",
type: 'post',
data: datastring,
success: function (data) {
 console.log($.trim(data));
 if($.trim(data) == 1){
   swal({
     title: "",
     text: "Appointment already booked",
    }, function () {
       $('#'+data_radio).prop('checked', false);
    })
 }
},
});
}
},
});
}
},
});
}
},
});
}
},
error: function () {
}
});
}
});
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>

<script type="text/javascript">
// $('#btn_submit').click(function(){
//   alert('done');
// });
/*$("#like_dislike").on("click", function() {
if ($("#like_dislike").hasClass("fa-heart-o")) {
$("#like_dislike").removeClass("fa-heart-o");
$("#like_dislike").addClass("fa-heart");
} else {
$("#like_dislike").removeClass("fa-heart");
$("#like_dislike").addClass("fa-heart-o");
}
});*/
$(document).ready(function($) {
$('.paymentRadio').click(function(event) {
$('.payment-errors').hide();
if($(this).val() == '1')
{
$('.stripePay').show();
$('.squreupPay').hide();
$('#squreupFrom').hide();
$('.googlePay').hide();
$('#sq-walletbox').hide();
}
else if($(this).val() == '2')
{
$('.stripePay').hide();
$('.squreupPay').show();
$('#squreupFrom').show();
$('.googlePay').hide();
$('#sq-walletbox').hide();
}
else if($(this).val() == '3')
{
$('.stripePay').hide();
$('.squreupPay').hide();
$('#squreupFrom').hide();
$('.googlePay').show();
$('#sq-walletbox').show();
if (SqPaymentForm.isSupportedBrowser()) {
console.log(paymentForm);
paymentForm.build();
paymentForm.recalculateSize();
}
}
});
});
document.addEventListener("DOMContentLoaded", function(event) {
if (SqPaymentForm.isSupportedBrowser()) {
console.log(paymentForm);
paymentForm.build();
paymentForm.recalculateSize();
}
});
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.4/vue.js'></script>
<script type="text/javascript">
Vue.component("step-navigation-step", {
template: "#step-navigation-step-template",

props: ["step", "currentstep"],

computed: {
indicatorclass() {
return {
active: this.step.id == this.currentstep,
complete: this.currentstep > this.step.id
};
}
}
});

Vue.component("step-navigation", {
template: "#step-navigation-template",

props: ["steps", "currentstep"]
});

Vue.component("step", {
template: "#step-template",

props: ["step", "stepcount", "currentstep"],

computed: {
active() {
return this.step.id == this.currentstep;
},

firststep() {
return this.currentstep == 1;
},

laststep() {
return this.currentstep == this.stepcount;
},

stepWrapperClass() {
return {
active: this.active
};
}
},

methods: {
nextStep() {
// alert(this.currentstep + 1);
var step = this.currentstep + 1;
var newthis = this;
if(step == 2)
{
var selected_services = [];
$("input:checkbox[name=radiog_list]:checked").each(function(){
selected_services.push($(this).val());
});

if(selected_services != '')
{
var service_id = selected_services;
$.ajax({
url: site_url+"appointment/get_select_service",
type: 'post',
data: {id:service_id},
success: function(data){
var data1 = JSON.parse(data);
// console.log(data1);
var category;
var parent_cat;
var html = '';

for (var i = 0; i < data1.length; i++) {
if(data1[i].und_sub_category != undefined)
{
category = data1[i].und_sub_category.cat_name+' - '+data1[i].sub_category.cat_name;
parent_cat = data1[i].service_name;
}
else if(data1[i].sub_category != undefined){
category = data1[i].sub_category.cat_name;
parent_cat = data1[i].service_name;
}else{
category = data1[i].service_name;
parent_cat = '';
}

var rating = "";
for (var j = 0; j < 5; j++) {
if(j < data1[i].ratingRound)
{
rating += '<span class="fa fa-star checked" id="star-'+j+'"></span>';
}
else
{
rating += '<span class="fa fa-star" id="star-'+j+'"></span>';
}
}
html += '<div class="col-md-6 leftbox2 cls_ap_2_step"><div class="col-md-5"><img src="'+data1[i].main_image+'" width="200px" height="150px"></div><div class="col-md-7"><div style="float: right;">'+rating+'</div><h3 style="color:#049597; margin-top: 25px;">'+category+'</h3><p style="padding-top: 3px">'+parent_cat+' <br>'+data1[i].shop_name+'</p><h2 style="margin-bottom: 0px; margin-top: 0px;color:#049597">$'+data1[i].price+'</h2><div class="radio_list_item"><input type="checkbox" name="radiog_list" id="radio10" checked="checked" value="1" class="css-checkbox cls-chk-service"><label for="radio10" class="css-label css-label-check"></label></div></div></div>';
}
$('.cls_services').append(html);
}
});
}

if(!$('input.cls-chk-service:checked').length > 0){
swal({
title: "",
text: "Please select service",

}, function () {
$('html, body').animate({
scrollTop: $('.service_slider_main').offset().top
}, 'slow');
})
return false;
}

var check = [];
$("input:checkbox[name=radiog_list]:checked").each(function(){
check.push($(this).val());
});
// console.log(check);
var shop_id = $('#shop_id').val();
console.log(shop_id);

if(check != '')
{
var cat_id = check;
$.ajax({
url: site_url+"appointment/get_worker_data",
type: 'post',
data: {cat_id:cat_id, shop_id:shop_id},
success: function (data) {
var cat_data = JSON.parse(data);
console.log(cat_data);

var j = '110';
var k = '1';
var html = '';
$('#array_worker_data').val(cat_data.length);

for (var i = 0; i < cat_data.length; i++) {
k++;
var name_array = cat_data[i].worker_data;
console.log(name_array);
var count_worker = name_array.length;
console.log(count_worker);
if(cat_data.length == 1){
var worker_id = name_array[0].worker_id;
var worker_checked = 'checked';
$.ajax({
    url: site_url+"appointment/get_one_worker_time",
    type: 'post',
    data: {worker_id:worker_id},
    success: function (data) {
      var cat_data = JSON.parse(data);
      console.log(cat_data);
      $('#time').val(cat_data);
    },
});
}else{
var worker_checked = '';
}

if(name_array == undefined){
  var msg = 'No worker available';
}
else{
var msg = '';
}
var rating = "";
for (var p = 0; p < 5; p++) {
if(p < cat_data[i].ratingRound)
{
  rating += '<i class="fa fa-star fa-2x star-checked" id="star-'+p+'" style="margin-right: 3px;"></i>';
}
else
{
  rating += '<i class="fa fa-star fa-2x" id="star-'+p+'" style="margin-right: 3px;"></i>';
}
}

price = parseFloat($("#priceData").val()) + parseFloat(cat_data[i].price);
$("#priceData").val(price)
html += '<div class="cls_main_worker_section"><div class="heading-left"><b>Select Worker - '+cat_data[i].service_name+' - $'+cat_data[i].price+'</b></div>'+msg;

$.each(name_array, function(index, value){
    j++;
    let isChecked = (count_worker == 1)?"checked":"";
   html += '<div class="staff" style="padding: 10px 20px; margin-left: 10px;"><label>'+name_array[index].worker_name +'</label><div class="radio_list_item_staff"><input type="hidden" name="services_name" id="services_name" class="css-checkbox cls-chk" value="'+cat_data[i].cat_id+'" data-services-id="'+cat_data[i].cat_id+'"/><input type="radio" '+ isChecked +' name="radiog_list'+k+'" id="radio'+j+'" class="css-checkbox cls-chk" value="'+name_array[index].worker_id+'" data-services-id="'+cat_data[i].id+'"  data-image-id="'+name_array[index].worker_id+'" data-radio-id="radio'+j+'" data-time-id="'+cat_data[i].time+'" data-cat-id="'+cat_data[i].cat_id+'" data-services-name="'+cat_data[i].service_name+'" data-price="'+cat_data[i].price+'"/><label for="radio'+j+'" class="css-label css-label-check" style="margin-right: 0px !important;"></label></div></div>';
});
html += '</div>';
}
// $('.cls-subsec').append(html);
$('.cls_worker_section').append(html);
},
});
}
newthis.$emit("step-change", newthis.currentstep + 1);
}
if(step == 3)
{
var worker_data_count = $('#array_worker_data').val();
var selected_services = [];
for (var i = 0; i < worker_data_count; i++) {
$("input:radio[name=radiog_list"+(i+2)+"]:checked").each(function(){
var serviceid = $(this).attr('data-services-id');
selected_services.push(serviceid);
});
}
$('#all_services_list').val(selected_services);
console.log(selected_services);
if(selected_services != '')
{
var service_id = selected_services;
$.ajax({
url: site_url+"appointment/get_select_service",
type: 'post',
data: {id:service_id},
success: function(data){
var data1 = JSON.parse(data);
// console.log(data1);
var category;
var html = '';
var parent_cat;
// var html = '<div class="col-md-12"><h3 style="margin-bottom:10px;">'+data1[0].shop_name+'</h3></div>';
for (var i = 0; i < data1.length; i++) {
if(data1[i].und_sub_category != undefined)
{
category = data1[i].und_sub_category.cat_name+' - '+data1[i].sub_category.cat_name;
parent_cat = data1[i].service_name;
}
else if(data1[i].sub_category != undefined){
category = data1[i].sub_category.cat_name;
parent_cat = data1[i].service_name;
}else{
category = data1[i].service_name;
parent_cat = '';
}

var rating = "";
for (var j = 0; j < 5; j++) {
if(j < data1[i].ratingRound)
{
rating += '<span class="fa fa-star checked" id="star-'+j+'"></span>';
}
else
{
rating += '<span class="fa fa-star" id="star-'+j+'"></span>';
}
}
html += '<div class="col-md-6 leftbox2 cls_ap_2_step"><div class="col-md-5"><img src="'+data1[i].main_image+'" width="200px" height="150px"></div><div class="col-md-7"><div style="float: right;">'+rating+'</div><h3 style="color:#049597; margin-top: 25px;">'+category+'</h3><p style="padding-top: 3px">'+parent_cat+' <br>'+data1[i].shop_name+'</p><h2 style="margin-bottom: 0px; margin-top: 0px;color:#049597">$'+data1[i].price+'</h2><div class="radio_list_item"><input type="checkbox" name="radiog_list" id="radio10" checked="checked" value="1" class="css-checkbox cls-chk-service"><label for="radio10" class="css-label css-label-check"></label></div></div></div>';
}
$('.cls_services1').append(html);
}
});
}

var price = $('#appoi_date').val();
if(price == ''){
swal({
title: "",
text: "Please select date",

}, function () {
$('html, body').animate({
scrollTop: $('.cls_appointment').offset().top
}, 'slow');
})
return false;
}

var main_time = $('#time').val();
if(main_time == ''){
swal({
title: "",
text: "Please select time",

}, function () {
$('html, body').animate({
scrollTop: $('.cls_appointment').offset().top
}, 'slow');
})
return false;
}

if(!$('input.cls-chk:checked').length > 0){
swal({
title: "",
text: "Please select worker",

}, function () {
$('html, body').animate({
scrollTop: $('.cls-subsec').offset().top
}, 'slow');
})
return false;
}
// alert(price);return false;
var check = [];
$("input:checkbox[name=radiog_list]:checked").each(function(){
check.push($(this).val());
});

var SerArr = [];

var worker_data_count = $('#array_worker_data').val();
var total = 0;
for (var i = 0; i < worker_data_count; i++) {
$("input:radio[name=radiog_list"+(i+2)+"]:checked").each(function(){
var categoryid = $(this).attr('data-cat-id');//category id
var serviceid = $(this).attr('data-services-id'); // services id
// var categoryid = $(this).prev().attr('value'); //serviceid
var timeid = $(this).attr('data-time-id'); //timeid
var workerid = $(this).val(); //workerid
var service_price = $(this).attr('data-price');
var services_name = $(this).attr('data-services-name');
total += parseFloat(service_price);

test = {'serviceid':serviceid,'timeid':timeid,'workerid':workerid,'services_name':services_name,'categoryid':categoryid,'service_price':service_price};
SerArr.push(test);
});
}
$('.cls_service_price').html('Total Amount: $'+total);
// console.log('SerArr',SerArr);
if(check != ''){
var services = check;
var servicesData = JSON.stringify(SerArr);
     // console.log(JSON.stringify(servicesData));
// console.log(servicesData1);
var cu_date = $('#appoi_date').val();
var cu_time = $('#time').val();
var leave_note = $('#leave_note').val();
var shop_id = $('#shop_id').val();


var datastring = 'services='+ services + '&all_services=' + servicesData + '&cu_date=' + cu_date + '&cu_time=' + cu_time + '&leave_note=' + leave_note + '&shop_id=' + shop_id;

$.ajax({
url: site_url+"appointment/insert_appointment",
type: 'post',
data: datastring,
success: function (data) {
// console.log('orderid',data);
$("#orderid").val(data);
// if(data == 1){
// }
// else{
//   swal("", "This worker is not available, please choose another worker.");
// }
},

});
}
this.$emit("step-change", this.currentstep + 1);
}
if(step == 4)
{
if($("#gift_chkbx").is(':checked')){
var user_email = $("#gift_user_email").val();
if(user_email == ''){
swal({
title: "",
text: "Please enter email",

}, function () {
$('html, body').animate({
scrollTop: $('.cls_top_email').offset().top
}, 'slow');
})
return false;
}
}

var discount_main_price = $("#discount_price").val();
if(discount_main_price != ''){
$("#priceData").val(discount_main_price);
}

if($(".paymentRadio:checked").val() == '1')
{
var token = "";
var card_name = $('#name_card').val();
var card_number = $('#card_number').val();
var card_cvv = $('#card_cvv').val();
var card_expiration = $("#card_expiration").val();
var res = card_expiration.split("/");
var month = res[0];
var year = res[1];
var orderid = $("#orderid").val();
var totalPrice = parseFloat($("#priceData").val());
if(card_number != "" && card_cvv != "" && card_expiration != "" && card_name != "")
{
$(".stripetoken").html("");
Stripe.createToken({
number: card_number,
cvc: card_cvv,
exp_month: month,
exp_year: year
}, stripeResponseHandler);
window.setTimeout(function(){
var payment_type = '1';
var token = $("#stripeToken").val();
var form_data = [{"name": "token","value": token},{"name": "orderid","value": orderid},{"name": "totalprice","value": totalPrice},{"name": "payment_type","value": payment_type}];
console.log('form_data',form_data);
// return false;
if(token != undefined && token != "")
{
$.ajax({
url: site_url+"appointment/payment",
type: 'post',
data: form_data,
success: function (data) {
$(".payment_message").html(data);
$(".payment_message").css('border', '1px solid #c2c2c2');
// alert(data);
// console.log('paymentdata',data);
},
});
}
else
{
console.log("token not find");
}
}, 3000);
//submit from callback
$("#overlay").show();
window.setTimeout(function(){
var tkn = $("#stripeToken").val();
// alert(tkn);
if(tkn != undefined && tkn != "")
{
newthis.$emit("step-change", newthis.currentstep + 1);
}
// alert("in");
$("#overlay").hide();
}, 5000);
// return false;
}
else
{
swal( "Oops" ,  "Please check required fields!" ,  "error" );
}
}
else if($(".paymentRadio:checked").val() == '2')
{
requestCardNonce('');
$("#overlay").show();
window.setTimeout(function(){
var payment_type = '2';
var orderid = $("#orderid").val();
var cardnonce = $("#card-nonce").val();
var totalPrice = parseFloat($("#priceData").val());
var form_data = [{"name": "token","value": cardnonce},{"name": "orderid","value": orderid},{"name": "totalprice","value": totalPrice},{"name": "payment_type","value": payment_type}];
console.log('form_data_squreup',form_data);
if(cardnonce != undefined && cardnonce != "")
{
$.ajax({
url: site_url+"appointment/paymentUsingSqureup",
type: 'post',
data: form_data,
success: function (data) {
console.log('data_squ',data);
$(".payment_message").html(data);
$(".payment_message").css('border', '1px solid #c2c2c2');
newthis.$emit("step-change", newthis.currentstep + 1);
$("#overlay").hide();
},
});
}
else
{
$("#overlay").hide();
console.log("token not find");
}
}, 3000);
}
else if($(".paymentRadio:checked").val() == '3')
{
$("#overlay").show();
window.setTimeout(function(){
var orderid = $("#orderid").val();
var payment_type = '3';
var totalPrice = parseFloat($("#priceData").val());
var form_data = [{"name": "orderid","value": orderid},{"name": "totalprice","value": totalPrice},{"name": "payment_type","value": payment_type}];
console.log('form_data_squreup',form_data);
$.ajax({
url: site_url+"appointment/paymentCash",
type: 'post',
data: form_data,
success: function (data) {
console.log('data_squ',data);
$(".payment_message").html(data);
$(".payment_message").css('border', '1px solid #c2c2c2');
newthis.$emit("step-change", newthis.currentstep + 1);
$("#overlay").hide();
},
});
}, 500);
}
else
{
// alert("else");
}
}
},

lastStep() {
this.$emit("step-change", this.currentstep - 1);
}
}
});

new Vue({
el: "#app",

data: {
currentstep: 1,

steps: [{
id: 1,
title: "Book Other Services",
subtitle: "Choose payment option for our service."
},
{
id: 2,
title: "Select Date",
subtitle: "Please choose the service along with your convenient time"
},
{
id: 3,
title: "Make Payment",
subtitle: "Choose payment option for our service."
},
{
id: 4,
title: "Pending Approval",
subtitle: "Confirmation will come later once provider confirms appointment"
}
]
},

methods: {
stepChanged(step) {
this.currentstep = step;
}
}
});
</script>


<script type="text/javascript">
var time_square = null;
$(".time_square > .square_btn").on("click", function() {
time_square = this.innerHTML;
$(".time_square > .square_btn").removeClass("active");

$(this).addClass('active');
});

// $(document).on('change', ".input-group-addon", function () {
//   alert('fgfg');
//   var value = $(this).val();
//     if ( value.length > 0  ) {
//          $('.cls-chk').prop('checked', false);
//     }
//
//   // $('.cls-chk').prop('checked', false);
//   // $('.cls-chk').removeProp('checked');
// });
</script>

<script type="text/javascript">
$(document).on('click', "#btn_promocode", function () {
$('.cls_promocode_msg').html('');
$("#discount_price").val('');
$('.cls_main_msg_promocode').hide();
var promocode = $('#promocode').val();
var total_price = parseFloat($("#priceData").val());
var total_services = $('#all_services_list').val();

var orderid = $("#orderid").val();
var datastring = 'promocode='+ promocode + '&price='+ total_price + '&total_services='+ total_services + '&orderid='+ orderid;
$('.cls_email_send_msg').html('');
$('.cls_promocode_msg').html('');
$('.cls_main_msg_promocode').html('');

if(promocode == ''){
$('.cls_promocode_msg').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="width:2%;">×</button>Please add promocode.</div>');
}else{
$.ajax({
url: "<?php echo base_url(); ?>appointment/Check_promocode",
type: 'post',
data: datastring,
success: function (data) {
var data1 = JSON.parse(data);
if(data1.length == 0){
$('.cls_promocode_msg').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="width:2%;">×</button>Promocode not match.</div>');
}else{
if(data1[0].main_data != 1){
$("#discount_price").val(data1[0].price);
var discount_main_price = $("#discount_price").val();
if(discount_main_price != ''){
var all_main_price = discount_main_price;
}else{
var all_main_price = total_price;
}
$('.cls_service_price').html('Total Amount: $'+data1[0].price);
$('.cls_main_msg_promocode').show();
$('.cls_main_msg_promocode').html('<div class="alert alert-success alert-dismissable" style="padding: 10px 18px;"><button type="button" style="background-color: #dff0d8;float:right;font-size:20px;margin-top:-13px;width:2%;    height: 1px;" id="cls_promocode_cancel" btn_ap_id= "'+data1[0].ap_id+'">×</button>Your applied promocode for '+data1[0].service_name+' : '+data1[0].promocode+'.</div>');
}else{
$('.cls_promocode_msg').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="width:2%;">×</button>Please apply a promo code with a price lower than the booking price.</div>');
$('.cls_service_price').html('Total Amount: $'+total_price);
}
}
$('#promocode').val('');
},
});
}
});
</script>

<script type="text/javascript">
$(document).on('click', "#cls_promocode_cancel", function () {
var ap_id = $(this).attr('btn_ap_id');
var total_price = parseFloat($("#priceData").val());
var orderid = $("#orderid").val();
var datastring = 'ap_id='+ ap_id + '&orderid='+ orderid;

$.ajax({
url: "<?php echo base_url(); ?>appointment/cancel_promocode",
type: 'post',
data: datastring,
success: function (data) {
// var data1 = JSON.parse(data);
$("#discount_price").val('');
$('.cls_service_price').html('Total Amount: $'+total_price);
$('.cls_main_msg_promocode').hide();
},
});
});
</script>

<script type="text/javascript">
$('.cls_gift_btn').hide();
$(document).on('click', "#gift_chkbx", function () {
if($("#gift_chkbx").is(':checked')){
$('.cls_gift_btn').show();
}else{
$('.cls_gift_btn').hide();
}
});
</script>

<script type="text/javascript">
$(document).on('click', "#btn_send", function () {
var orderid = $('#orderid').val();
var gift_email = $('#gift_user_email').val();
var datastring = 'orderid='+ orderid + '&gift_email='+ gift_email;

$.ajax({
url: "<?php echo base_url(); ?>appointment/send_gift_email",
type: 'post',
data: datastring,
success: function (data) {
$('#gift_user_email').val('');
if(data == 1){
$("#gift_chkbx").prop("checked", false);
$('.cls_email_send_msg').html('');
$('.cls_promocode_msg').html('');
$('.cls_main_msg_promocode').html('');
$('.cls_email_send_msg').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="width: 2%;">×</button>Email sent successfully.</div>');
$('.cls_top_email').hide();
}else{
$('.cls_email_send_msg').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="width: 2%;">×</button>Email not sent, Please try again.</div>');
}
},
});
});
</script>

<script src="<?=base_url()?>front/js/owl.carousel.min.js"></script>
<script type="text/javascript">
var service_carousel = $('.service_carousel');
// service_carousel.owlCarousel();
service_carousel.owlCarousel({
margin: 0,
nav: false,
loop: false,
items: 2,
rewind: true,
responsive: { 0: { items: 1 }, 850: { items: 2 }}
})

$('.service_carousel_customNextBtn').click(function() { service_carousel.trigger('next.owl.carousel'); })
$('.service_carousel_customPrevBtn').click(function() { service_carousel.trigger('prev.owl.carousel', [300]); })
</script>
