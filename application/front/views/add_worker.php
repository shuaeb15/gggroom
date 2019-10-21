<?php $this->load->view('templates/_include/header_view1'); ?>

<style media="screen">
.dlt_shop_btn{
    width: 200px !important;
}
.save_shop_btn{
    width: 200px !important;
}
label.css-label-check {
    margin-right: 26px !important;
}

.cls-worker-info{
    height: 36px !important;
    text-align: left !important;
    color: #000 !important;
    height: 50px !important;
    border-radius: 0 !important;
    text-align: left !important;
    font-weight: 500 !important;
    font-size: 15px !important;
    background: #fff !important;
    border: none !important;
    border-bottom: 1px solid #299494 !important;
    box-shadow: none !important;
    width: 100%
  }
  .css-label-check{
    margin-bottom: 0px !important;
    margin-top: 16px !important;
  }
  .business_hrs{
    margin-bottom: 10px;
  }
  .cls-time-lable{
    width: 15% !important;
  }
  .cls-all-time{
    margin-bottom: 10px;
  }
  .cls-all-time p{
    font-size: 15px !important;
    line-height: 25px !important;
  }
  .cls-time-input{
    border-radius: 4px;
    text-align: left;
    border: solid 2px #008080;
    margin-bottom:10px;
    font-size: 20px;
  }
  input[type="checkbox"], input[type="radio"] {
    position: unset;
    right: 0px;
    width: 16px;
    height: 16px;
}
.cls-chk{
  font-size: 20px;
    margin-bottom: 18px;
}
.cls_all_service{
  margin-right: 10px !important;
  margin-left: 88px !important;
}

.cl_lbl_time{
    width: 12%;
    font-size:21px;
}
.cl_lbl_end_time{
    width: 12%;
    font-size:21px;
    margin-left:70px;
}
@media only screen and (max-width:480px){
  .cl_lbl_time{
      width: 100%;
  }
  .cl_lbl_end_time{
      width: 100%;
      margin-left:0px;
  }
  .cls_day{
    width: 100% !important;
  }
  .cls_day label.css-label-check{
    margin-bottom: 0px !important;
  }
  .cls-chk{
    border-right: none !important;
  }
}
</style>

<section class="block bg_white">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12">
        <div class="edit-form shop-form">
          <?php if ($this->session->flashdata('error_message')) { ?>
                  <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?php echo $this->session->flashdata('error_message'); ?> </div>
          <?php } ?>
          <?php if ($this->session->flashdata('success_message')) { ?>
                  <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                  <?php echo $this->session->flashdata('success_message'); ?> </div>
          <?php } ?>
          <form enctype="multipart/form-data" method="post"  id="add_worker" name="add_worker" data-toggle="validator" action="<?php echo site_url("worker/insert_worker"); ?>">
            <div class="col-xs-12 col-sm-12 col-md-12 css_title" style="text-align: center;">
                <span class="form-title" style="float:none;font-size: 25px;margin: 0 auto 30px auto;">Add worker</span>
            </div>
            <div class="image_change">
                <input type="file" id="imgupload" name="imgupload" style="display:none" onchange="readURL(this);"/>
                <img src="<?=base_url()?>front/images/banner.jpg" alt="" id="preview_image" title="" class="img-responsive img-circle upload_img" />
                <a id="OpenImgUpload"> <img src="<?=base_url()?>front/images/camera.png" alt="" title="" class="img-responsive img-circle camera_upload" /> </a>
            </div>
            <p class="imagechangetxt">Change Profile Image</p>
            <hr class="hr_line">
            <div class="col-md-12 col-xs-12">
                <span class="form-title">Worker Info</span>
            </div>
            <input type="hidden" name="worker_id" id="worker_id" value="<?=$workerlist->id?>"/>
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="no-border cls-worker-info" Placeholder="Worker Name *" name="worker_name" id="worker_name" value="<?=$workerlist->name?>">
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class="form-group cls_form_group">
                <input type="email" class="cls-worker-info"  Placeholder="Worker Email *" name="worker_email" id="worker_email" value="<?=$workerlist->email?>">
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class="form-group cls_form_group">
                <input type="text" class="cls-worker-info"  Placeholder="Mobile No *"  name="worker_mobile" id="worker_mobile" value="<?=$workerlist->mobile?>">
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class="form-group cls_form_group">
                <input type="number" min="0" class="cls-worker-info"  Placeholder="Percentage" name="worker_percentage" id="worker_percentage" value="<?=$workerlist->percentage?>">
              </div>
            </div>
            <div class="col-md-12 col-xs-12 cls_select_shop">
                <hr class="hr_line">
            </div>
            <div class="col-md-12 col-xs-12">
                <span class="form-title">Select Shop <span class="cls_star">*</span></span>
            </div>
            <?php
            $i = 7;
            foreach ($shoplist as $key => $shop) {
              $i++;?>
              <div class="col-md-12 col-xs-12 margin_bottom_30">
                <div class="business_hrs">
                  <div class="col-md-12 col-xs-12">
                    <div class="col-md-11 col-xs-18 business_hrs_inner">
                      <span><?=$shop->shop_name?> </br> <span style="font-size: 16px; color: rgba(0, 0, 0, 0.502);"> <?=$shop->addline1?><?php if($shop->addline2 != ''){ echo ', ';}?><?=$shop->addline2?><?php if($shop->city_name != ''){ echo ', ';}?><?=$shop->city_name?><?php if($shop->state_name != ''){ echo ', ';}?><?=$shop->state_name?><?php if($shop->zipcode != ''){ echo ', ';}?><?=$shop->zipcode?> </span> </span>
                    </div>
                    <input type="hidden" name="shop_id" id="shop_id" value="<?=$shop->id?>"/>
                    <div class="col-md-1 col-xs-6 business_hrs_inner">
                      <input type="radio" name="radiog_list" id="radio<?=$i?>" class="css-checkbox radiog_list" value="<?=$shop->id?>">
                      <label for="radio<?=$i?>" class="css-label css-label-check"></label>
                    </div>
                  </div>
                </div>
              </div>
              <?php }?>
            <div class="col-md-12 col-xs-12 cls_business_hours">
              <hr class="hr_line">
            </div>
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Business Hours <span class="cls_star">*</span></span>
                <a href="javascript:void(0)" class="btn_add btn_add_img" onclick="changeDisplay();">
                  <img src="<?=base_url()?>front/images/delete.png" class="btn_add img_business">
                </a>
            </div>
            <div class="item form-group " id="cls-day-time">
              <div class="col-xs-12 cls-chk">
                <p id="datepairExample1">
                <input type="text" class="date start hide">
                <label class="cl_lbl_time">Start Time</label>
                <input type="text" class="time start ui-timepicker-input cls-time-input" id="Monday1" name="Monday1">
                <label class="cl_lbl_end_time">End Time</label>
                <input type="text" class="time end ui-timepicker-input cls-time-input" id="Monday2" name="Monday2">
                <input type="text" class="date end hide">
                  </p>
              </div>
              <div class="col-md-12 col-xs-12">
                <span class="form-title">Breaks</span>
              </div>
              <div class="item form-group " id="cls-breaks-time">
                <div class="col-xs-12 cls-chk">
                  <p id="datepairExample_breaks1">
                  <input type="text" class="date start hide">
                  <label class="cl_lbl_time">Start Time</label>
                  <input type="text" class="time start ui-timepicker-input cls-time-input" id="break_Monday1" name="break_Monday1">
                  <label class="cl_lbl_end_time">End Time</label>
                  <input type="text" class="time end ui-timepicker-input cls-time-input" id="break_Monday2" name="break_Monday2">
                  <input type="text" class="date end hide">
                    </p>
                </div>
              </div>
              <div class="col-xs-2 cls-chk cls_radio_btn" style="border-right: 1px solid lightgrey;">
                <input type="radio" name="radio_day" id="radio787" class="css-checkbox radio_day" onclick="ChangeWorkingDay('1');" checked value="1"/>
                <label for="radio787" class="css-label radGroup1 radGroup2">
                  <span>Daily</span>
                </label>
                <input type="radio" name="radio_day" id="radio788" class="css-checkbox radio_day" onclick="ChangeWorkingDay('2');" value="2"/>
                <label for="radio788" class="css-label radGroup1 radGroup2">
                  <span>Weekly</span>
                </label>
                <!-- <input type="radio" name="radio_day" id="radio789" class="css-checkbox radio_day" onclick="ChangeWorkingDay('3');" value="3"/>
                <label for="radio789" class="css-label radGroup1 radGroup2">
                  <span>Monthly</span>
                </label>
                <input type="radio" name="radio_day" id="radio1780" class="css-checkbox radio_day" onclick="ChangeWorkingDay('4');" value="4"/>
                <label for="radio1780" class="css-label radGroup1 radGroup2">
                  <span>Yearly</span>
                </label> -->
              </div>
              <div class="col-xs-10 cls-chk cls_day">
                <input type="checkbox" name="service_time[]" id="service_day1" class="css-checkbox cls_all_service" value="Monday" checked>
                <label for="service_day1" class="css-label css-label-check dayCB">Monday</label>
                <input type="checkbox" name="service_time[]" id="service_day2" class="css-checkbox cls_all_service" value="Tuesday" checked>
                <label for="service_day2" class="css-label css-label-check dayCB">Tuesday</label>
                <input type="checkbox" name="service_time[]" id="service_day3" class="css-checkbox cls_all_service" value="Wednesday" checked>
                <label for="service_day3" class="css-label css-label-check dayCB">Wednesday</label>
                <input type="checkbox" name="service_time[]" id="service_day4" class="css-checkbox cls_all_service" value="Thursday" checked>
                <label for="service_day4" class="css-label css-label-check dayCB">Thurday</label>
                <input type="checkbox" name="service_time[]" id="service_day5" class="css-checkbox cls_all_service" value="Friday" checked>
                <label for="service_day5" class="css-label css-label-check dayCB">Friday</label>
                <input type="checkbox" name="service_time[]" id="service_day6" class="css-checkbox cls_all_service" value="Saturday" checked>
                <label for="service_day6" class="css-label css-label-check dayCB">Saturday</label>
                <input type="checkbox" name="service_time[]" id="service_day7" class="css-checkbox cls_all_service" value="Sunday" checked>
                <label for="service_day7" class="css-label css-label-check dayCB">Sunday</label>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line margin_bottom_30">
            </div>
            <div class="col-md-12" style="margin-bottom: 22px;">
              <input type="checkbox" name="worker_permission" id="worker_permission" class="css-checkbox">
              <label for="worker_permission" class="css-label css-label-check" style="font-size: 23px;">Add Shop Permission</label>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line margin_bottom_30">
            </div>
            <div class="col-md-12 center_btn_main">
              <div class="center_btn_sub">
                <div class="center_btn_subitem">
                  <button type="button" class="dlt_shop_btn" id="btn-submit">Cancel</button>
                </div>
                <div class="center_btn_subitem">
                  <button type="submit" class="save_shop_btn cls_add_worker">Add worker</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
$('#OpenImgUpload').click(function() { $('#imgupload').trigger('click'); });
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#preview_image').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $('#btn-submit').click(function() {
    window.location.href = '<?php echo base_url();?>worker';
  });
</script>


<script type="text/javascript">
$(document).ready(function(){
  $('.cls-hours-id').click(function() {
    var id = $(this).attr('data-image-id');

    swal({
      title: "Are you sure?",
      text: "You want to delete this record",
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
            url: "<?php echo base_url(); ?>worker/delete_business_hours_time",
            type: 'post',
            data: {id:id},
            success: function (data) {
              $( ".cls-business_hrs"+id ).remove();
              // swal("Deleted!", "Your record has been deleted.", "success");
            },
        });
      } else {
        // swal("Cancelled", "record not deleted", "error");
      }
    });
  });
});

function changeDisplay() {
var x = document.getElementById("cls-day-time");

if (x.style.display === "none") {
x.style.display = "block";
$('.img_business').attr('src','<?php echo base_url(); ?>front/images/delete.png');

var shop_id = $('input[name=radiog_list]:checked').val();
var datastring = 'shop_id=' + shop_id;
$.ajax({
    url: "<?php echo base_url(); ?>shop/uncheck_hours_day_checkbox",
    type: 'post',
    data: datastring,
    success: function (data) {
      var data_array = JSON.parse(data);
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
      }
    },
    error: function () {
    }
});

} else {
x.style.display = "none";
$('.img_business').attr('src','<?php echo base_url(); ?>front/images/add.png');
}
}

function ChangeWorkingDay(argument) {
  if(argument == '1')
  {
    for (var j = 1; j <= 7; j++) {
      if($("#service_day"+j).prop('disabled') == false){
          $("#service_day"+j).prop("checked", true);
      }else{
          $("#service_day"+j).prop("checked", false);
      }
    }
  }
  if(argument == '2')
  {
    for (var j = 1; j <= 5; j++) {
      if($("#service_day"+j).prop('disabled') == false){
          $("#service_day"+j).prop("checked", true);
      }else{
          $("#service_day"+j).prop("checked", false);
      }
    }
    $("#service_day6").prop("checked", false);
    $("#service_day7").prop("checked", false);
  }
  if(argument == '3')
  {
    $("#service_day1").prop("checked", false);
    $("#service_day2").prop("checked", false);
    $("#service_day3").prop("checked", false);
    $("#service_day4").prop("checked", false);
    $("#service_day5").prop("checked", false);
    $("#service_day6").prop("checked", false);
    $("#service_day7").prop("checked", false);
  }
  if(argument == '4')
  {
    $("#service_day1").prop("checked", false);
    $("#service_day2").prop("checked", false);
    $("#service_day3").prop("checked", false);
    $("#service_day4").prop("checked", false);
    $("#service_day5").prop("checked", false);
    $("#service_day6").prop("checked", false);
    $("#service_day7").prop("checked", false);
  }
}
</script>
