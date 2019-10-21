<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>

<link href="<?php echo base_url('../front/css/gggroom.css?ver=1.3');?>" rel="stylesheet">
<style media="screen">
.cls-time-title{
  font-size: 22px;
color: rgb(0, 0, 0);
font-weight: bold;
margin-bottom: 10px;
}
.business_hrs{
  margin-bottom: 10px;
}
.cls_break_day_time{
  margin-right: 10px !important;
  margin-left: 88px !important;
}
.cls-chk{
  font-size: 20px;
    margin-bottom: 18px;
}
.cls-chk input{
  width: auto !important;
  height: auto !important;
}
.cls-time-input{
  border-radius: 4px;
  text-align: left;
  border: solid 2px #008080;
  margin-bottom:10px;
  font-size: 20px;
}
.cls_shop_info{
  height: 36px;
border-radius: 4px;
text-align: left;
/* border: solid 2px #008080; */
font-size: 14px;
/* background: #f3f3f3; */
margin-left: 10px;
}
.cls_lable_info{
  /* border: solid 2px #008080;
  border-radius: 4px; */
  margin-left: -9px;
    /* background: #f3f3f3;
    font-weight: 100; */
}
.cls_main{
  margin-bottom: 25px;
}
.cls_breaks{
  border-radius: 4px;
text-align: left;
padding: 10px;
/* border: solid 2px #008080; */
font-size: 14px;
/* background: #f3f3f3; */
margin-left: 10px;
}
.cls_radio{
  margin-right: 10px;
}
.camera_upload{
  margin-top: -27px;
  margin-left: 93px;
  width: 35px;
}
.upload_img{
  width: 150px;
    height: 150px;
}
.cls-chk1 label{
    font-weight: 100;
    font-size: 20px;
}
.cls-chk1{
	font-size: 25px !important;
}
.cls-chk1 input{
	width: 17px !important;
  height: 17px !important;
  margin-right: 6px !important;
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

.cl_lbl_time1{
    width: 22% !important;
    margin-left: 18px !important;
    font-size: 13px !important;
    text-transform: uppercase !important;
}
.cl_lbl_end_time1{
  width: 23% !important;
  margin-left: 18px !important;
  font-size: 13px !important;
  text-transform: uppercase !important;
  margin-top: 25px !important;
}
.ui-multiselect{
  border: 1px solid #ccc !important;
  height: 34px !important;
  background-color: #fff !important;
}
.ui-multiselect-checkboxes span{
  margin-left: 7px;
}
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover{
  background:#ccc !important;
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
  .business_hrs span {
    font-size: 15px;
  }
  .business_hrs img {
    margin-right: 10px;
  }
  .cls_all_field{
        width:100%;
    }
}

</style>
<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Shop</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <form enctype="multipart/form-data" method="post"  id="edit_shop1" name="edit_shop1" data-toggle="validator" action="<?=base_url()?>shop/update_shop/<?=$shop_data->encrypt_id?>">
            <input type="hidden" class="form-control cls_lable_info" name="shop_id" id="shop_id" value="<?=$shop_data->id?>">
            <input type="hidden" name="edit_shop_check" id="edit_shop_check" value="1">
          <div class="x_title">
            <h2>Edit shop</h2>
            <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- <div class="col-md-12 cls_main">
              <div class="item form-group"> -->
                <div class="image_change">
                <?php
                $img = $shop_data->image;
                $temp_file = base_url()."../front/images/banner.jpg";
                $main_file = "../assets/uploads/shop/".$img;
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
                    <input type="file" id="imgupload1" name="imgupload1" style="display:none" />
                    <img src="<?=$main_image?>" alt="" id="preview_image" title="" class="img-responsive img-circle upload_img" />
                    <a id="OpenImgUpload1"> <img src="<?=base_url()?>../front/images/camera.png" alt="" title="" class="img-responsive img-circle camera_upload" /> </a>
                </div>
                <p class="imagechangetxt">Change Image</p>
                <hr class="hr_line">
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Shop Name</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="shop_name" id="shop_name" value="<?=$shop_data->shop_name?>">
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Shop Email</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="shop_email" id="shop_email" value="<?=$shop_data->shop_email?>">
                  </div>
                 </div>
              </div>
              <div class="col-md-12 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Phone No</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="mobile_no" id="mobile_no" value="<?=$shop_data->mobile?>">
                  </div>
                 </div>
              </div>
              <!-- <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Title</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="shop_title" id="shop_title" value="<?=$shop_data->title?>">
                  </div>
                 </div>
              </div> -->
              <div class="col-md-6 cls_main cls_all_field cls_addline">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Address Line 1</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="address_1" id="address_1" value="<?=$shop_data->addline1?>">
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Address Line 2</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="address_2" id="address_2" value="<?=$shop_data->addline2?>">
                  </div>
                 </div>
              </div>
              <?php $city_arr = explode(',', $shop_data->city);?>
              <div class="col-md-4 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">City</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field" style="margin-left: 0px;width: 90% !important;">
                    <select class="city form-control" id="city" name="city[]" multiple="multiple">
                      <?php foreach ($city as $val) {?>
                        <option <?php foreach($city_arr as $main_city){if($main_city == $val->id){ echo 'selected'; }}?> value="<?=$val->id?>"><?=$val->name?></option>
                        <?php }?>
                    </select>
                    <!-- <input type="text" class="form-control cls_lable_info" name="city" id="city" value="<?=$shop_data->city_name?>"> -->
                  </div>
                 </div>
              </div>
              <div class="col-md-4 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">State</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <select class="form-control cls_lable_info" name="state" id="state">
                      <?php $state_edit = $shop_data->state;?>
                      <option value="">--Select--</option>
                      <?php foreach ($state as $val) {?>
                        <option <?php if($state_edit == $val->id){ echo 'selected';}?> value="<?=$val->id?>"><?=$val->name;?></option>
                        <?php }?>
                    </select>
                  </div>
                 </div>
              </div>
              <div class="col-md-4 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Zip code</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="text" class="form-control cls_lable_info" name="zipcode" id="zipcode" value="<?=$shop_data->zipcode?>">
                  </div>
                 </div>
              </div>
              <div class="col-md-12 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1">Description</label><br>
                  <div class="col-md-12 cls_all_field">
                    <textarea rows="8" class="form-control cls_lable_info cls_all_field" name="discription" id="discription" placeholder="Please add a description"><?=$shop_data->description?></textarea>
                  </div>
                 </div>
              </div>
              <div class="col-md-12 col-xs-12">
                <hr class="hr_line margin_bottom_30">
              </div>
              <div class="col-md-12 col-xs-12 cls-time-title cls_all_field">
                <span class="form-title">Cancelletion Policy <span class="cls_star">*</span></span>
              </div>
              <div class="col-md-12 col-xs-12">
                <div class="cls-chk1">
                  <?php $cancel_policy = $shop_data->cancel_policy;?>
                  <div class="col-md-2 col-xs-12">
                    <label class="cls_all_field">
                      <input type="radio" name="radiog_dark" id="radiog_dark" <?php if($cancel_policy == '1'){ echo 'checked';}else if($cancel_policy == ''){ echo 'checked';}?> value="1" >Strict<br><span style="font-size: 16px;">No cancellation</span></label>
                  </div>
                  <div class="col-md-3 col-xs-12">
                    <label class="cls_all_field">
                    <input type="radio" name="radiog_dark" id="radiog_dark" value="2" <?php if($cancel_policy == '2'){ echo 'checked';}?>>Moderate<br><span style="font-size: 16px;">Cancellation before 48 hours</span></label>
                  </div>
                  <div class="col-md-3 col-xs-12">
                    <label class="cls_all_field">
                    <input type="radio" name="radiog_dark" id="radiog_dark" value="3" <?php if($cancel_policy == '3'){ echo 'checked';}?>>Flexible<br><span style="font-size: 16px;">Anytime cancellation</span></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-xs-12 cls_business_hours">
                <hr class="hr_line margin_bottom_30">
              </div>
              <div class="col-md-12">
                <input type="checkbox" name="chk_vacation_module" id="radio8" class="css-checkbox chk_vacation_module"/>
                <label for="radio8" class="css-label css-label-check radGroup1 radGroup2" style="margin-bottom: 15px !important;"><span class="form-title" style="font-size: 20px;">Shop Vacation</span>
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
                         <input type='text' id="start_date_v_module" name="start_date_v_module" class="form-control vacation_datepicker1" value="" style="cursor:pointer;"/>
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
                         <input type='text' id="end_date_v_module" name="end_date_v_module" class="form-control vacation_datepicker2" value="" style="cursor:pointer;"/>
                         <span class="input-group-addon input-group-addon2" style="cursor:pointer;padding: 0px 12px !important;">
                         <span class="fa fa-caret-down"></span>
                         </span>
                      </div>
                    </div>
                   </div>
                </div>
                <div class="col-md-9 cls_all_time">
                  <div class="col-xs-12 cls-chk">
                    <p id="datepairExample1">
                    <input type="text" class="date start hide">
                    <label class="cl_lbl_time1">Start Time</label>
                    <input type="text" class="time start ui-timepicker-input cls-time-input" id="start_time" name="start_time" style="width: 48% !important;">
                    <label class="cl_lbl_end_time1">End Time</label>
                    <input type="text" class="time end ui-timepicker-input cls-time-input" id="end_time" name="end_time" style="width: 48% !important;margin-left: -7px !important;">
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
                          <div class="col-md-10 business_hrs_inner">
                            <img src="<?=base_url()?>../front/images/cal_blck.png">
                            <span><?=date("d F Y", strtotime($vacation->start_date))?> <?=$starting_time?> to <?=date("d F Y", strtotime($vacation->end_date))?> <?=$ending_time?></span>
                          </div>
                        </div>
                        <a href="javascript:void(0)" class="btn_add btn_add_img">
                          <img src="<?=base_url()?>../front/images/close.png" class="close cls-vacation-id" data-shop-id="<?=$vacation->id?>">
                        </a>
                      </div>
                    <?php }?>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-xs-12 cls_business_hours">
                <hr class="hr_line">
              </div>
              <div class="col-md-12 col-xs-12 cls-time-title">
                <span class="form-title">Business Hours <span class="cls_star">*</span></span>
                  <a href="javascript:void(0)" class="btn_add btn_add_img" onclick="changeDisplay();" style="float:right;">
                    <img src="<?=base_url()?>../front/images/add.png" class="btn_add img_business" style="width: 30px;">
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
                <!-- <div class="col-md-12 col-xs-12 cls-time-title">
                  <span class="form-title">Breaks <span class="cls_star">*</span></span>
                </div>
                <div class="item form-group " id="cls-breaks-time">
                  <div class="col-xs-12 cls-chk">
                    <p id="datepairExample_breaks1">
                    <input type="text" class="date start hide">
                    <label style="width: 12%;font-size:21px;">Start Time</label>
                    <input type="text" class="time start ui-timepicker-input cls-time-input" id="break_Monday1" name="break_Monday1" style="margin-bottom:10px;font-size: 20px;">
                    <label style="width: 12%;font-size:21px;margin-left:70px;">End Time</label>
                    <input type="text" class="time end ui-timepicker-input cls-time-input" id="break_Monday2" name="break_Monday2" style="margin-bottom:10px;font-size: 20px;">
                    <input type="text" class="date end hide">
                      </p>
                  </div>
                </div> -->
                <div class="col-xs-2 cls-chk" style="border-right: 1px solid lightgrey;">
                  <input type="radio" name="radio_day" id="radio7" class="css-checkbox radio_day" onclick="ChangeWorkingDay('1');" checked value="1"/>
                  <label for="radio7" class="css-label  radGroup1 radGroup2">
                    <span>Daily</span>
                  </label>
                  <input type="radio" name="radio_day" id="radio8" class="css-checkbox radio_day" onclick="ChangeWorkingDay('2');" value="2"/>
                  <label for="radio8" class="css-label  radGroup1 radGroup2">
                    <span>Weekly</span>
                  </label>
                  <input type="radio" name="radio_day" id="radio9" class="css-checkbox radio_day" onclick="ChangeWorkingDay('3');" value="3"/>
                  <label for="radio9" class="css-label  radGroup1 radGroup2">
                    <span>Monthly</span>
                  </label>
                  <input type="radio" name="radio_day" id="radio10" class="css-checkbox radio_day" onclick="ChangeWorkingDay('4');" value="4"/>
                  <label for="radio10" class="css-label  radGroup1 radGroup2">
                    <span>Yearly</span>
                  </label>
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
                <?php foreach ($business_hours as $key => $hours) {?>
                  <div class="business_hrs cls-business_hrs<?=$hours->id?>">
                    <div class="col-md-12 col-xs-12">
                      <div class="col-md-6 col-xs-12 business_hrs_inner">
                        <img src="<?=base_url()?>../front/images/cal_blck.png">
                        <span><?=$hours->hours_day?></span>
                      </div>
                      <div class="col-md-6 col-xs-12 business_hrs_inner">
                        <img src="<?=base_url()?>../front/images/clock.png">
                        <span><?=date("g:i A", strtotime($hours->from_time))?> --- <?=date("g:i A", strtotime($hours->to_time))?></span>
                      </div>
                    </div>
                    <a href="javascript:void(0)" class="btn_add btn_add_img">
                        <img src="<?=base_url()?>../front/images/close.png" class="close cls-hours-id" data-image-id="<?=$hours->id?>" data-day="<?=$hours->hours_day?>">
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
                      <img src="<?=site_url()?>../front/images/cal_white.png" class="black_cal">
                  </a>
                </div>
              </div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-3">
                    <input type="button" onclick="location.href = '<?php echo base_url(); ?>shop'" class="btn btn-primary" value="Cancel">
                    <button id="send" type="submit" class="btn btn-success edit_shop_btn">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="Stylesheet"></link>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>

<script type="text/javascript">
$(document).ready(function(){
$("#city").multiselect({
header: ['checkAll','uncheckAll'],
});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
  $('#datepairExample_breaks1 .time').timepicker({
      'showDuration': true,
      'timeFormat': 'g:i A'
  });
  $('#datepairExample_breaks1').datepair();

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
});

$('.cls_break_day_time').prop('checked', true);
$('.cls_all_service').prop('checked', true);

<?php if(!empty($business_hours)){?>
        $('#cls-day-time').hide();
<?php }else{?>
        $('.img_business').attr('src','<?php echo base_url(); ?>../front/images/delete.png');
<?php }?>

</script>

<script type="text/javascript">
$('#OpenImgUpload1').click(function() { $('#imgupload1').trigger('click'); });
</script>

<script type="text/javascript">
$(document).ready(function(){
var _URL = window.URL || window.webkitURL;
$(document).on('change', "#imgupload1", function () {
  if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          $('#preview_image').attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
  }

  // $('#preview_image').attr('src', img_val);
  // alert(img_val);

 var files = $('#imgupload1')[0].files;
 var error = '';
 var form_data = new FormData();
 var image_width = 485;
 // var image_height = 485;

 var name = files[0].name;
 var imageSize = files[0].size;
 var extension = name.split('.').pop().toLowerCase();

 if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
 {
    error += "Please select only gif, png, jpg or jpeg file"
 }
 if (imageSize > 2097152) {
   error += "Please select image size less than 2 MB"
 }

 if(error != '')
 {
   swal({
         title: "",
         text: error,

     }, function () {
       $("#preview_image").attr("src","")

     })
     return false;
   }
  });
});
</script>

<!-- <script type="text/javascript">
$(document).ready(function(){
  $('.cls-hours-id').click(function() {
    var id = $(this).attr('data-image-id');
    var hour_day = $(this).attr('data-day');
    var shop_id = $('#shop_id').val();
    var datastring = 'id='+ id +'&shop_id=' + shop_id +'&hour_day=' + hour_day;

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
            url: "<?php echo base_url(); ?>shop/delete_business_hours_time",
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
</script> -->

<script type="text/javascript">
$(document).ready(function(){
  $('.cls-hours-id').click(function() {
    var id = $(this).attr('data-image-id');
    var hour_day = $(this).attr('data-day');
    var shop_id = $('#shop_id').val();
    var datastring = 'id='+ id +'&shop_id=' + shop_id +'&hour_day=' + hour_day;

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
            url: "<?php echo base_url(); ?>shop/delete_business_hours_time",
            type: 'post',
            data: datastring,
            success: function (data) {
              $( ".cls-business_hrs"+id ).remove();
              // $( ".cls-breaks"+data ).remove();
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
function changeDisplay() {
var x = document.getElementById("cls-day-time");

  if (x.style.display === "none") {
    x.style.display = "block";
    $('.img_business').attr('src','<?php echo base_url(); ?>../front/images/delete.png');

    var shop_id = $('#shop_id').val();
    var datastring = 'shop_id=' + shop_id;
    $.ajax({
        url: "<?php echo base_url(); ?>shop/uncheck_hours_day_checkbox",
        type: 'post',
        data: datastring,
        success: function (data) {
          var data_array = JSON.parse(data);
          console.log(data_array);
          var Blank_Arr = [];
          for (var i = 0; i < data_array.length; i++) {
            Blank_Arr.push(data_array[i].hours_day);
          }
          console.log(Blank_Arr);
        },
        error: function () {
        }
    });

  } else {
    x.style.display = "none";
    $('.img_business').attr('src','<?php echo base_url(); ?>../front/images/add.png');

  }
}

function ChangeWorkingDay(argument) {
  if(argument == '1')
  {
    $("#service_day1").prop("checked", true);
    $("#service_day2").prop("checked", true);
    $("#service_day3").prop("checked", true);
    $("#service_day4").prop("checked", true);
    $("#service_day5").prop("checked", true);
    $("#service_day6").prop("checked", true);
    $("#service_day7").prop("checked", true);
  }
  if(argument == '2')
  {
    $("#service_day1").prop("checked", true);
    $("#service_day2").prop("checked", true);
    $("#service_day3").prop("checked", true);
    $("#service_day4").prop("checked", true);
    $("#service_day5").prop("checked", true);
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
     var shop_id = $('#shop_id').val();
     var start_date = $('.vacation_datepicker1').val();
     var datastring = 'start_date='+ start_date +'&shop_id=' + shop_id;

     $.ajax({
         url: "<?php echo base_url(); ?>shop/check_vacation_module_start_time",
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
                          scrollTop: $('#radiog_dark').offset().top
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
   var shop_id = $('#shop_id').val();
   var end_date = $('.vacation_datepicker2').val();
   var datastring = 'start_date='+ start_date +'&end_date=' + end_date +'&shop_id=' + shop_id;

   if(start_date == ''){
     swal({
           title: "",
           text: "Please select first start date",
       }, function () {
         $('.vacation_datepicker2').val('');
         $('html, body').animate({
                 scrollTop: $('#radiog_dark').offset().top
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
                   scrollTop: $('#radiog_dark').offset().top
               }, 'slow');
         })
     }else{
       $.ajax({
           url: "<?php echo base_url(); ?>shop/check_vacation_module_end_time",
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
                            scrollTop: $('#radiog_dark').offset().top
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
  var shop_id = $('#shop_id').val();
  var datastring = 'id='+ id +'&shop_id=' + shop_id;

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
          url: "<?php echo base_url(); ?>shop/delete_vacation_module_time",
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

 $(document).on('click', ".edit_shop_btn", function () {

     if($(".cls_vacation_module").is(':visible')){
       var starttime = $('#start_date_v_module').val();
       var endtime = $('#end_date_v_module').val();

       if(starttime == ''){
         swal({
               title: "",
               text: "Please select vacation start date",

           }, function () {
             $('html, body').animate({
                     scrollTop: $('#radiog_dark').offset().top
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
                     scrollTop: $('#radiog_dark').offset().top
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
                       scrollTop: $('#radiog_dark').offset().top
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
                       scrollTop: $('#radiog_dark').offset().top
                   }, 'slow');
             })
             return false;
         }
       }
     }
   });

   $(document).on('change', "#state", function () {
       var form_data = [{"name": "state_id","value": $(this).val()}];
       $.ajax({
           url: site_url + 'shop/get_state_time',
           type: "POST",
           data: form_data,
           success: function(data) {
               var test = data.split('||');

               $('#datepairExample1 .time').timepicker({
                 'showDuration': true,
                 'timeFormat': 'g:i A',
               });
               $('#datepairExample1 .time').timepicker('option', 'minTime', test[1]);
               $('#datepairExample1 .time').timepicker('option', 'maxTime', test[2]);
           }
       });
     });

     var all_state = $('#state').val();
     if(all_state != ''){
       var form_data = [{"name": "state_id","value": all_state}];
       $.ajax({
           url: site_url + 'shop/get_state_time',
           type: "POST",
           data: form_data,
           success: function(data) {
               var test = data.split('||');

               $('#datepairExample1 .time').timepicker({
                 'showDuration': true,
                 'timeFormat': 'g:i A',
               });
               $('#datepairExample1 .time').timepicker('option', 'minTime', test[1]);
               $('#datepairExample1 .time').timepicker('option', 'maxTime', test[2]);
           }
       });
     }
});
</script>
