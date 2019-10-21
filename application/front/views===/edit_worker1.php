<?php $this->load->view('templates/_include/header_view1'); ?>

<style media="screen">
.dlt_shop_btn{
    width: 230px !important;
}
.save_shop_btn{
    width: 230px !important;
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
.cls_btn_back{
  margin-left: -185px;
  margin-right: 10px;
  float: right;
  font-size: 20px;
  color: #fff;
  background: #059797;
  border: none;
  height: auto;
  padding: 9px 30px;
}
.cls_btn_back:hover{
  color: #fff;
  background: #059797;
}

.cl_lbl_time1{
    width: 22%;
    margin-left: 18px;
    font-size: 16px !important;
    text-transform: uppercase !important;
}
.cl_lbl_end_time1{
  width: 23%;
  margin-left: 18px;
  font-size: 16px !important;
  text-transform: uppercase !important;
  margin-top: 25px;
}

@media only screen and (max-width:480px){
  .cls_btn_back{
    width: -1%;
    margin-left: -185px;
    margin-right: 5px;
    font-size: 16px;
    padding: 9px 17px;
  }

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
  .business_hrs span {
    font-size: 15px;
  }
  .business_hrs img {
    margin-right: 10px;
    height: 20px;
    width: 20px;
    margin-left: -23px;
  }
  .cls_vacation_module input{
      width: 100% !important;
  }
  .cls_vacation_module label{
      width: 100% !important;
  }
  .switch_title{
    margin-top: 0px !important;
    margin-left: 0px !important;
  }
  .switch_title label{
    width: 38% !important;
  }
  .cls_btn_back{
    margin-bottom: 25px;
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
          <form enctype="multipart/form-data" method="post"  id="edit_worker" name="edit_worker" data-toggle="validator" action="<?php echo site_url("worker/update_worker/$workerlist->encrypt_id"); ?>">
            <div class="col-xs-12 col-sm-12 col-md-12 css_title" style="text-align: center;">
                <a href="<?php echo base_url();?>worker" class="btn btn-default cls_btn_back"><span>Go back</span></a>
                <span class="form-title" style="float:none;font-size: 25px;margin: 0 auto 30px auto;">Edit worker</span>
            </div>
            <div class="image_change">
              <?php
              $img = $workerlist->image;
              $temp_file = base_url()."front/images/banner.jpg";
              $main_file = "assets/uploads/worker_image/".$img;
              $filename = FCPATH.$main_file;
              if (file_exists($filename)) {
                if($img != ''){
                    $main_image =  base_url().$main_file;
                }else{
                    $main_image =  $temp_file;
                }
              }else{
                $main_image =  $temp_file;
              }?>
              <input type="file" id="imgupload" name="imgupload" style="display:none" onchange="readURL(this);"/>
              <img src="<?=$main_image?>" alt="" id="preview_image" title="" class="img-responsive img-circle upload_img" />
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
              <div class="form-group">
                <input type="email" class="cls-worker-info"  Placeholder="Worker Email *" name="worker_email" id="worker_email" value="<?=$workerlist->email?>">
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <input type="text" class="cls-worker-info"  Placeholder="Mobile No *"  name="worker_mobile" id="worker_mobile" value="<?=$workerlist->mobile?>">
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <input type="number" class="cls-worker-info" min="0" Placeholder="Percentage" name="worker_percentage" id="worker_percentage" value="<?=$workerlist->percentage?>">
              </div>
            </div>
            <div class="col-md-12 col-xs-12 cls_select_shop">
                <hr class="hr_line">
            </div>
            <div class="col-md-12 col-xs-12">
                <span class="form-title">Select Shop <span class="cls_star">*</span></span>
                <input type="hidden" name="edit_worker_check" id="edit_worker_check" value="1">
            </div>
            <?php
            $i = 7;
            foreach ($shoplist as $shop) {
              $i++;?>
              <?php $check_shop_id = $workerlist->shop_id;?>
              <div class="col-md-12 col-xs-12 margin_bottom_30">
                <div class="business_hrs">
                  <div class="col-md-12 col-xs-12">
                    <div class="col-md-11 col-xs-18 business_hrs_inner">
                      <span><?=$shop->shop_name?> </br> <span style="font-size: 16px; color: rgba(0, 0, 0, 0.502);"> <?=$shop->addline1?><?php if($shop->addline2 != ''){ echo ', ';}?><?=$shop->addline2?><?php if($shop->city_name != ''){ echo ', ';}?><?=$shop->city_name?><?php if($shop->state_name != ''){ echo ', ';}?><?=$shop->state_name?><?php if($shop->zipcode != ''){ echo ', ';}?><?=$shop->zipcode?> </span> </span>
                    </div>
                    <input type="hidden" name="shop_id" id="shop_id" value="<?=$shop->id?>"/>
                    <div class="col-md-1 col-xs-6 business_hrs_inner">
                      <input type="radio" name="radiog_list" id="radio<?=$i?>" class="css-checkbox radiog_list" value="<?=$shop->id?>" <?php if($shop->id == $check_shop_id){ echo 'checked';}else if($check_shop_id == '0'){ echo 'checked';}?>>
                      <label for="radio<?=$i?>" class="css-label css-label-check"></label>
                    </div>
                  </div>
                </div>
              </div>
              <?php }?>
            <div class="col-md-12 col-xs-12 cls_business_hours cls_top">
              <hr class="hr_line">
            </div>
            <div class="col-md-12">
              <input type="checkbox" name="chk_vacation_module" id="radio7" class="css-checkbox chk_vacation_module"/>
              <label for="radio7" class="css-label css-label-check radGroup1 radGroup2" style="margin-bottom: 15px !important;"><span class="form-title">Worker Vacation</span>
            </div>
            <div class="col-md-12 " style="margin-top:20px;">
              <div class="cls_vacation_module">
              <div class="col-md-9">
                 <div class="form-group">
                   <div class="col-md-3" style="margin-top: 10px;">
                     <label style="margin-left: 20px;">START DATE</label>
                   </div>
                   <div class="col-md-6">
                    <div class='input-group date' id='vacation_datepicker1'>
                       <input type='text' id="start_date_v_module" name="start_date_v_module" class="form-control vacation_datepicker1" value="" style="cursor:pointer;    width: 101% !important;"/>
                       <span class="input-group-addon input-group-addon1" style="cursor:pointer;padding: 0px 12px !important;">
                       <span class="fa fa-caret-down"></span>
                       </span>
                    </div>
                  </div>
                 </div>
              </div>
              <div class="col-md-9" style="margin-top:20px;margin-bottom:20px;">
                 <div class="form-group">
                   <div class="col-md-3" style="margin-top: 10px;">
                     <label style="margin-left: 20px;">END DATE</label>
                   </div>
                   <div class="col-md-6">
                    <div class='input-group date' id='vacation_datepicker2'>
                       <input type='text' id="end_date_v_module" name="end_date_v_module" class="form-control vacation_datepicker2" value="" style="cursor:pointer;width: 101% !important;"/>
                       <span class="input-group-addon input-group-addon2" style="cursor:pointer;padding: 0px 12px !important;">
                       <span class="fa fa-caret-down"></span>
                       </span>
                    </div>
                  </div>
                 </div>
              </div>
              <div class="col-md-9 cls_all_time">
                <div class="col-xs-12 cls-chk">
                  <p id="datepairExample_vacation1">
                  <input type="text" class="date start hide">
                  <label class="cl_lbl_time1">Start Time</label>
                  <input type="text" class="time start ui-timepicker-input cls-time-input" id="start_time" name="start_time" style="width: 48%;">
                  <label class="cl_lbl_end_time1">End Time</label>
                  <input type="text" class="time end ui-timepicker-input cls-time-input" id="end_time" name="end_time" style="width: 48%;margin-left: -7px;">
                  <input type="text" class="date end hide">
                    </p>
                </div>
              </div>
              <div class="col-md-9" style="margin-top:3px;">
                <div class="col-xs-12 cls-chk">
                  <label class="cl_lbl_time1">All Day</label>
                  <div class="form-group switch_title" style="margin-top: -40px;margin-left: 168px;float: none;">
                    <label class="switch">
                      <input type="checkbox" class="appoinemnt_slider" id="all_day" name="all_day">
                      <span class="slider round"></span>
                    </label>
                </div>
                </div>
              </div>
              </div>
              <div class="col-md-9 cls_list_vacation" style="margin-top:40px;">
                <div class="" style="text-align:center;">
                  <?php if(!empty($vacation_module_data)){?>
                        <label style="margin-bottom:20px;font-size: 22px;">List of vacations</label>
                  <?php }?>
                </div>
                <div class="col-md-12 col-xs-12 margin_bottom_30">
                  <?php foreach ($vacation_module_data as $key => $vacation) {
                    $time1 = date("H:i:s", strtotime($vacation->start_date));
                    $time2 = date("H:i:s", strtotime($vacation->end_date));
                    if($time1 == "00:00:00"){
                        $starting_time = '';
                    }else{
                        $starting_time = ' -- '.date("g:i A", strtotime($vacation->start_date));
                    }

                    if($time2 == "23:59:00"){
                        $ending_time = '';
                    }else{
                        $ending_time = ' -- '.date("g:i A", strtotime($vacation->end_date));
                    }?>
                    <div class="business_hrs cls-vacation_module_id<?=$vacation->id?>">
                      <div class="col-md-12">
                        <div class="col-md-11 business_hrs_inner">
                          <img src="<?=base_url()?>front/images/cal_blck.png">
                          <span><?=date("d F Y", strtotime($vacation->start_date))?> <?=$starting_time?> to <?=date("d F Y", strtotime($vacation->end_date))?> <?=$ending_time?></span>
                        </div>
                      </div>
                      <a href="javascript:void(0)" class="btn_add btn_add_img">
                        <img src="<?=base_url()?>front/images/close.png" class="close cls-vacation-id" data-shop-id="<?=$vacation->id?>">
                      </a>
                    </div>
                  <?php }?>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-xs-12 cls_business_hours">
              <hr class="hr_line">
            </div>
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Business Hours <span class="cls_star">*</span></span>
                <a href="javascript:void(0)" class="btn_add btn_add_img" onclick="changeDisplay();">
                  <img src="<?=base_url()?>front/images/add.png" class="btn_add img_business">
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
                <input type="radio" name="radio_day" id="radio50" class="css-checkbox radio_day" checked onclick="ChangeWorkingDay('1');" value="1"/>
                <label for="radio50" class="css-label  radGroup1 radGroup2">
                  <span>Daily</span>
                </label>
                <input type="radio" name="radio_day" id="radio51" class="css-checkbox radio_day" onclick="ChangeWorkingDay('2');" value="2"/>
                <label for="radio51" class="css-label  radGroup1 radGroup2">
                  <span>Weekly</span>
                </label>
                <!-- <input type="radio" name="radio_day" id="radio52" class="css-checkbox radio_day" onclick="ChangeWorkingDay('3');" value="3"/>
                <label for="radio52" class="css-label  radGroup1 radGroup2">
                  <span>Monthly</span>
                </label>
                <input type="radio" name="radio_day" id="radio53" class="css-checkbox radio_day" onclick="ChangeWorkingDay('4');" value="4"/>
                <label for="radio53" class="css-label  radGroup1 radGroup2">
                  <span>Yearly</span>
                </label> -->
              </div>
              <div class="col-xs-10 cls-chk cls_day">
                <input type="checkbox" name="service_time[]" id="service_day1" class="css-checkbox cls_all_service" value="Monday">
                <label for="service_day1" class="css-label css-label-check dayCB">Monday</label>
                <input type="checkbox" name="service_time[]" id="service_day2" class="css-checkbox cls_all_service" value="Tuesday">
                <label for="service_day2" class="css-label css-label-check dayCB">Tuesday</label>
                <input type="checkbox" name="service_time[]" id="service_day3" class="css-checkbox cls_all_service" value="Wednesday">
                <label for="service_day3" class="css-label css-label-check dayCB">Wednesday</label>
                <input type="checkbox" name="service_time[]" id="service_day4" class="css-checkbox cls_all_service" value="Thursday">
                <label for="service_day4" class="css-label css-label-check dayCB">Thurday</label>
                <input type="checkbox" name="service_time[]" id="service_day5" class="css-checkbox cls_all_service" value="Friday">
                <label for="service_day5" class="css-label css-label-check dayCB">Friday</label>
                <input type="checkbox" name="service_time[]" id="service_day6" class="css-checkbox cls_all_service" value="Saturday">
                <label for="service_day6" class="css-label css-label-check dayCB">Saturday</label>
                <input type="checkbox" name="service_time[]" id="service_day7" class="css-checkbox cls_all_service" value="Sunday">
                <label for="service_day7" class="css-label css-label-check dayCB">Sunday</label>
              </div>
            </div>

            <div class="col-md-12 col-xs-12 margin_bottom_30">
              <?php foreach ($business_hours as $key => $hours) {
                ?>
                <div class="business_hrs cls-business_hrs<?=$hours->id?>">
                  <div class="col-md-12 col-xs-12">
                    <div class="col-md-6 col-xs-12 business_hrs_inner">
                      <img src="<?=base_url()?>front/images/cal_blck.png">
                      <span><?=$hours->worker_day?></span>
                    </div>
                    <div class="col-md-6 col-xs-12 business_hrs_inner">
                      <img src="<?=base_url()?>front/images/clock.png">
                      <span><?=date("g:i A", strtotime($hours->from_time))?> --- <?=date("g:i A", strtotime($hours->to_time))?></span>
                    </div>
                  </div>
                  <a href="javascript:void(0)" class="btn_add btn_add_img">
                      <img src="<?=base_url()?>front/images/close.png" class="close cls-hours-id" data-image-id="<?=$hours->id?>" data-day="<?=$hours->worker_day?>">
                  </a>
                </div>
              <?php }?>
              <div class="business_hrs business_hrs_bottom">
                <div class="col-md-12 col-xs-12">
                  <div class="col-md-12 col-xs-12">
                    <span>This schedule is for all week.</span>
                  </div>
                </div>
                <a href="<?=base_url()?>calendar" class="btn_add btn_add_img">
                    <img src="<?=base_url()?>front/images/cal_white.png" class="black_cal">
                </a>
              </div>
            </div>
            <?php if(!empty($breaks)){?>
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Breaks time</span></span>
            </div>
          <?php }?>
            <div class="col-md-12 col-xs-12 margin_bottom_30">
              <?php foreach ($breaks as $key => $breaks_time) {?>
                <div class="business_hrs breaks cls-breaks<?=$breaks_time->id?>">
                  <div class="col-md-12 col-xs-12">
                    <div class="col-md-6 col-xs-12 business_hrs_inner">
                      <img src="<?=base_url()?>front/images/cal_blck.png">
                        <span><?=$breaks_time->day?></span>
                    </div>
                    <div class="col-md-6 col-xs-12 business_hrs_inner">
                      <img src="<?=base_url()?>front/images/clock.png">
                        <span><?=date("g:i A", strtotime($breaks_time->from_time))?> --- <?=date("g:i A", strtotime($breaks_time->to_time))?></span>
                    </div>
                  </div>
                  <a href="javascript:void(0)" class="btn_add btn_add_img">
                      <img src="<?=base_url()?>front/images/close.png" class="close cls-breaks-id" data-image-id="<?=$breaks_time->id?>">
                  </a>
                </div>
            <?php }?>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line margin_bottom_30">
            </div>
            <?php
              if($workerlist->shop_permission != 1){?>
                <div class="col-md-12" style="margin-bottom: 22px;">
                  <input type="checkbox" name="worker_permission" id="worker_permission" class="css-checkbox">
                  <label for="worker_permission" class="css-label css-label-check" style="font-size: 23px;">Add Shop Permission</label>
                </div>
                <div class="col-md-12 col-xs-12">
                  <hr class="hr_line margin_bottom_30">
                </div>
            <?php }?>
            <div class="col-md-12 center_btn_main">
              <div class="center_btn_sub">
                <div class="center_btn_subitem">
                  <button type="button" class="dlt_shop_btn" onclick="delete_worker();">Delete worker</button>
                </div>
                <div class="center_btn_subitem">
                  <button type="submit" class="save_shop_btn  cls_add_worker">Save Changes</button>
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
  var site_url = $("#site_url").val();

  $(".appoinemnt_slider").on("click", function() {
  if($(".appoinemnt_slider").is(':checked')){
    $('.cls_all_time').hide();
    $('#start_time').val('');
    $('#end_time').val('');
  }
  else{
    $('.cls_all_time').show();
  }
  });
  $(document).ready(function(){
    $('#datepairExample_vacation1 .time').timepicker({
        'showDuration': true,
        'timeFormat': 'g:i A'
    });
    $('#datepairExample_vacation1').datepair();
  });
</script>
<script type="text/javascript">
$('.cls_all_service').prop('checked', true);

<?php if(!empty($business_hours)){?>
          $('#cls-day-time').hide();
          $('.img_business').attr('src','<?php echo base_url(); ?>front/images/add.png');
<?php }else{?>
          $('.img_business').attr('src','<?php echo base_url(); ?>front/images/delete.png');
<?php }?>
</script>

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
</script>

<script type="text/javascript">
  function delete_worker() {
    var worker_id  = $('#worker_id').val();
    window.location.href = '<?php echo base_url(); ?>worker/delete_worker/'+worker_id;
  }
</script>

<script type="text/javascript">
$(document).ready(function(){
  $('.cls-hours-id').click(function() {
    var id = $(this).attr('data-image-id');
    var hour_day = $(this).attr('data-day');
    var worker_id = $('#worker_id').val();
    var datastring = 'id='+ id +'&worker_id=' + worker_id +'&hour_day=' + hour_day;

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
            data: datastring,
            success: function (data) {
              $( ".cls-business_hrs"+id ).remove();
              $( ".cls-breaks"+data ).remove();
              // swal("Deleted!", "Your record has been deleted.", "success");
            },
            error: function () {
            }
        });
      } else {
        // swal("Cancelled", "record not deleted", "error");
      }
    });

  });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
  $('.cls-breaks-id').click(function() {
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
          url: "<?php echo base_url(); ?>worker/delete_breaks_time",
          type: 'post',
          data: {id:id},
          success: function (data) {
            $( ".cls-breaks"+id ).remove();
          },
          error: function () {
          }
        });
      } else {
        // swal("Cancelled", "record not deleted", "error");
      }
    });

  });
});
</script>

<script type="text/javascript">
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

$("#Monday1").val('');
$("#Monday2").val('');
var form_data = [{"name": "shopid","value": shop_id}];
$.ajax({
    url: site_url + 'worker/CheckShopTime',
    type: "POST",
    data: form_data,
    success: function(data) {

        var test = data.split('||');
        var dayArr = $.parseJSON(test[0]);
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

$(document).ready(function(){

var shop_id = $('input[name=radiog_list]:checked').val();
var form_data = [{"name": "shopid","value": shop_id}];
$.ajax({
    url: site_url + 'worker/CheckShopTime',
    type: "POST",
    data: form_data,
    success: function(data) {

        var test = data.split('||');
        var dayArr = $.parseJSON(test[0]);
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

$('#datepairExample1').on('changeTime', function() {
    $("#break_Monday1").val("");
    $("#break_Monday2").val("");
    $('#datepairExample_breaks1 .time').timepicker('option', 'minTime', $("#Monday1").val());
    $('#datepairExample_breaks1 .time').timepicker('option', 'maxTime', $("#Monday2").val());
});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
  $(".cls_vacation_module").hide();
  <?php if(empty($vacation_module_data)){?>
    $(".cls_list_vacation").hide();
  <?php }?>

  var date = new Date();
  date.setDate(date.getDate()-1);
   $('.vacation_datepicker1').datetimepicker({
      format: 'MM-DD-YYYY',
      // defaultDate: new Date(),
      minDate: date,
   }).on('dp.change', function (e) {
     var worker_id = $('#worker_id').val();
     var start_date = $('.vacation_datepicker1').val();
     var datastring = 'start_date='+ start_date +'&worker_id=' + worker_id;

     $.ajax({
         url: "<?php echo base_url(); ?>worker/check_vacation_module_start_time",
         type: 'post',
         data: datastring,
         success: function (data) {
            var data1 = JSON.parse(data);
            if(data1 != 0){
              swal({
                    title: "",
                    text: "This date is already in vacation mode, Please select another date",

                }, function () {
                  $('.vacation_datepicker1').val('');
                  $('.vacation_datepicker2').val('');
                  $('html, body').animate({
                          scrollTop: $('.cls_top').offset().top
                      }, 'slow');
                })
            }
         },
         error: function () {
         }
     });
    });
    $('.input-group-addon1').on('click', function() {
    $(this).prev('.vacation_datepicker1').data('DateTimePicker').toggle();
 });

 $('.vacation_datepicker2').datetimepicker({
    format: 'MM-DD-YYYY',
    // defaultDate: new Date(),
    minDate: date
 }).on('dp.change', function (e) {
   var start_date = $('.vacation_datepicker1').val();
   var worker_id = $('#worker_id').val();
   var end_date = $('.vacation_datepicker2').val();
   var datastring = 'start_date='+ start_date +'&end_date=' + end_date +'&worker_id=' + worker_id;

   if(start_date == ''){
     swal({
           title: "",
           text: "Please select first start date",
       }, function () {
         $('.vacation_datepicker2').val('');
         $('html, body').animate({
                 scrollTop: $('.cls_top').offset().top
             }, 'slow');
       })
   }else{
     if (start_date >= end_date) {
       swal({
             title: "",
             text: "End date must be after start date",

         }, function () {
           $('.vacation_datepicker2').val('');
           $('html, body').animate({
                   scrollTop: $('.cls_top').offset().top
               }, 'slow');
         })
     }else{
       $.ajax({
           url: "<?php echo base_url(); ?>worker/check_vacation_module_end_time",
           type: 'post',
           data: datastring,
           success: function (data) {
              var data1 = JSON.parse(data);
              if(data1 != 0){
                swal({
                      title: "",
                      text: "This date is already in vacation mode, Please change start date or end date",

                  }, function () {
                    $('.vacation_datepicker1').val('');
                    $('.vacation_datepicker2').val('');
                    $('html, body').animate({
                            scrollTop: $('.cls_top').offset().top
                        }, 'slow');
                  })
              }
           },
           error: function () {
           }
       });
     }
   }
  });
  $('.input-group-addon2').on('click', function() {
  $(this).prev('.vacation_datepicker2').data('DateTimePicker').toggle();
});

$('.chk_vacation_module').click(function() {
  if($(".chk_vacation_module").is(':checked')){
    $(".cls_vacation_module").show();
  }else{
    $(".cls_vacation_module").hide();
  }
});

$('.cls-vacation-id').click(function() {
  var id = $(this).attr('data-shop-id');
  var worker_id = $('#worker_id').val();
  var datastring = 'id='+ id +'&worker_id=' + worker_id;

  swal({
    title: "Are you sure?",
    text: "You want to delete",
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
          url: "<?php echo base_url(); ?>worker/delete_vacation_module_time",
          type: 'post',
          data: datastring,
          success: function (data) {
            $( ".cls-vacation_module_id"+id ).remove();
          },
          error: function () {
          }
      });
    }
  });
 });

 $(document).on('click', ".cls_add_worker", function () {

     if($(".cls_vacation_module").is(':visible')){
       var starttime = $('#start_date_v_module').val();
       var endtime = $('#end_date_v_module').val();

       if(starttime == ''){
         swal({
               title: "",
               text: "Please select vacation start date",

           }, function () {
             $('html, body').animate({
                     scrollTop: $('.cls_top').offset().top
                 }, 'slow');
           })
           return false;
       }
       else if(endtime == ''){
         swal({
               title: "",
               text: "Please select vacation end date",

           }, function () {
             $('html, body').animate({
                     scrollTop: $('.cls_top').offset().top
                 }, 'slow');
           })
           return false;
       }
       if($(".cls_all_time").is(':visible')){
         var main_starttime = $('#start_time').val();
         var main_endtime = $('#end_time').val();

         if(main_starttime == ''){
           swal({
                 title: "",
                 text: "Please select vacation start time",

             }, function () {
               $('html, body').animate({
                       scrollTop: $('.radio_policy').offset().top
                   }, 'slow');
             })
             return false;
         }
         else if(main_endtime == ''){
           swal({
                 title: "",
                 text: "Please select vacation end time",

             }, function () {
               $('html, body').animate({
                       scrollTop: $('.radio_policy').offset().top
                   }, 'slow');
             })
             return false;
         }
       }
     }
   });
});
</script>
