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
.col-md-6 {
    width: 50% !important;
}
.btn_image_add{
  border-color: rgb(37, 144, 144) !important;
  width: 90px !important;
}
.cls_policy_p{
    margin: 0 !important;
    padding: 0 !important;
}
  .image_preview_item img{
    width: auto;
    height: 201px;
  }
  .image_preview_item{
    margin-bottom: 30px;
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
.cls_break_day_time{
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

@media only screen and (max-width:480px){
  .cls_v_div{
    padding:0px;
  }
  .cls_btn_back{
    width: -1%;
    margin-left: -185px;
    margin-right: 5px;
    font-size: 16px;
    padding: 9px 17px;
  }

  .col-md-6 {
      width: 100% !important;
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
/* .btn2{
background: white;
border: none;
margin-top: 2px;
font-size: 26px;
padding: 0px 0px !important;
color: grey;
}
.btn2:hover{
border: none;
}
.btn2:after {
    font-family: "Glyphicons Halflings";
    content: "\e080";
    float: right;
    margin-left: 15px;
  }
  .btn2.collapsed:after {
    content: "\e114";
  } */
</style>
<!-- <div class="col-md-12">
   <div class="form-group">
     <div class="col-md-9" style="margin-top: 10px;">
       <label>START DATE</label>
     </div>
     <div class="col-md-3">
      <div class='input-group date' id='vacation_datepicker1'>
        <input type='text' id="start_date_v_module" name="start_date_v_module" class="form-control vacation_datepicker1" value="" style="cursor:pointer;border: none;background:white;width:79%"/>
        <button type="button" class="btn2 btn-lg collapsed input-group-addon1" data-toggle="collapse" data-target="#demo"></button>
      </div>
    </div>
    <div id="demo" class="collapse">
    </div>
   </div>
</div>
 <hr class="hr_line"> -->
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

          <form enctype="multipart/form-data" method="post"  id="edit_shop" name="edit_shop" data-toggle="validator" action="<?php echo site_url("shop/update_shop/$shoplist->encrypt_id"); ?>">
            <div class="col-xs-12 col-sm-12 col-md-12 css_title" style="text-align: center;">
              <a href="<?php echo base_url();?>shop" class="btn btn-default cls_btn_back"><span>Go back</span></a>
              <span class="form-title" style="float:none;font-size: 25px;margin: 0 auto 30px auto;">Edit shop</span>
            </div>
            <div class="image_change">
            <?php
            $img = $shoplist->image;
            $temp_file = base_url()."front/images/banner.jpg";
            $main_file = "assets/uploads/shop/".$img;
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
            <input type="file" id="imgupload1" name="imgupload1" style="display:none" onchange="readURL(this);"/>
            <img src="<?=$main_image?>" alt="" id="preview_image" title="" class="img-responsive img-circle upload_img" />
            <a id="OpenImgUpload1"> <img src="<?=base_url()?>front/images/camera.png" alt="" title="" class="img-responsive img-circle camera_upload" /> </a>
            </div>
            <p class="imagechangetxt">Change Profile Image</p>
            <hr class="hr_line">

            <div class="col-md-12 col-xs-12">
              <span class="form-title">Shop multiple photos</span>
                <button type="button" id="OpenImgUpload" class="btn-default btn_border btn_add btn_image_add">Add</button>
            </div>

            <div class="image_change">
              <input type="file" name="files" id="imgupload" multiple style="display:none" />
            </div>
            <div class="col-md-12 col-xs-12 image_preview">
              <div class="row" id="uploaded_images">
                <?php
                foreach ($shop_image_list as $key => $images) {?>
                  <?php
                  $img = $images->image;
                  $main_file = "assets/uploads/shop_image/".$img;
                  $filename = FCPATH.$main_file;
                  if (file_exists($filename)) {
                    $main_image =  base_url().$main_file;
                  }else{
                    $main_image =  '';
                  }

                  if($main_image != ''){?>
                    <div class="col-md-4 col-xs-12 image_preview_item img_item<?=$images->id?>">
                      <img src="<?=$main_image?>" class="img-responsive">
                      <img src="<?=base_url()?>front/images/close.png" class="close image_delete" data-image-id="<?=$images->id?>">
                    </div>
                <?php }
              }?>
                </div>
              </div>
              <hr class="hr_line">
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Shop Info</span>
            </div>
            <input type="hidden" name="shop_id" id="shop_id" value="<?=$shoplist->id?>"/>
            <input type="hidden" name="edit_shop_check" id="edit_shop_check" value="1">
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="fname">Shop Name <span class="cls_star">*</span></label>
                <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?=$shoplist->shop_name?>">
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="lname">Shop Email <span class="cls_star">*</span></label>
                <input type="email" class="form-control" name="shop_email" id="shop_email" value="<?=$shoplist->shop_email?>">
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="uname">Phone No <span class="cls_star">*</span></label>
                <input type="number" class="form-control" name="mobile_no" id="mobile_no" value="<?=$shoplist->mobile?>">
              </div>
            </div>
            <div class="col-md-12 col-xs-12 cls_addline">
              <div class="form-group">
                <label for="pwd">Address Line 1 <span class="cls_star">*</span></label>
                <input type="text" class="form-control" name="address_1" id="address_1" value="<?=$shoplist->addline1?>">
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="cpwd">Address Line 2</label>
                <input type="text" class="form-control" name="address_2" id="address_2" value="<?=$shoplist->addline2?>">
              </div>
            </div>
            <!-- <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="uname">City <span class="cls_star">*</span></label>
                <select class="city form-control" id="city" name="city[]" multiple="multiple">
                  <?php foreach ($city as $val) {?>
                    <option <?php foreach($city_arr as $main_city){if($main_city == $val->id){ echo 'checked'; }}?> value="<?=$val->id?>"><?=$val->name?></option>
                    <?php }?>
                </select>

                <input type="text" class="form-control" name="city" id="city" value="<?=$shoplist->city_name?>">
              </div>
            </div> -->
            <?php $city_arr = explode(',', $shoplist->city);?>
            <div class="col-md-12 col-xs-12">
              <div class="row">
                <div class="col-md-4 col-xs-12" style="width: 29% !important;">
                  <div class="form-group">
                    <label for="uname">City <span class="cls_star">*</span></label><br>
                    <select class="city form-control" id="city" name="city[]" multiple="multiple">
                      <?php foreach ($city as $val) {?>
                        <option <?php foreach($city_arr as $main_city){if($main_city == $val->id){ echo 'selected'; }}?> value="<?=$val->id?>"><?=$val->name?></option>
                        <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="email">State <span class="cls_star">*</span></label>
                    <select class="form-control" name="state" id="state">
                      <?php $state_edit = $shoplist->state;?>
                      <option value="">--Select--</option>
                      <?php foreach ($state as $val) {?>
                        <option <?php if($state_edit == $val->id){ echo 'selected';}?> value="<?=$val->id;?>"><?=$val->name;?></option>
                        <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="">Zip code <span class="cls_star">*</span></label>
                    <input type="number" class="form-control" name="zipcode" id="zipcode" value="<?=$shoplist->zipcode?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="">Description <span class="cls_star">*</span></label>
                <textarea rows="8" class="form-control" name="discription" id="discription" placeholder="Please add a description"><?=$shoplist->description?></textarea>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line">
            </div>
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Cancelletion Policy <span class="cls_star">*</span></span>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="row radio_policy">
                <?php $cancel_policy = $shoplist->cancel_policy;?>
                <div class="col-md-4 col-xs-12">
                  <input type="radio" name="radiog_dark" id="radio4" class="css-checkbox" <?php if($cancel_policy == '1'){ echo 'checked';}else if($cancel_policy == ''){ echo 'checked';}?> value="1"/>
                  <label for="radio4" class="css-label css-label-check radGroup1 radGroup2"><p class="cls_policy_p">Strict</p>
                    <span>No cancellation</span>
                  </label>
                </div>
                <div class="col-md-4 col-xs-12">
                  <input type="radio" name="radiog_dark" id="radio5" class="css-checkbox" value="2" <?php if($cancel_policy == '2'){ echo 'checked';}?> />
                  <label for="radio5" class="css-label css-label-check radGroup1 radGroup2"><p class="cls_policy_p">Moderate</p>
                    <span>Cancellation before 48 hours</span>
                  </label>
                </div>
                <div class="col-md-4 col-xs-12">
                  <input type="radio" name="radiog_dark" id="radio6" class="css-checkbox" value="3" <?php if($cancel_policy == '3'){ echo 'checked';}?> />
                  <label for="radio6" class="css-label css-label-check radGroup1 radGroup2"><p class="cls_policy_p">Flexible</p>
                    <span>Anytime cancellation</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line">
            </div>
            <div class="col-md-12">
              <input type="checkbox" name="chk_vacation_module" id="radio101" class="css-checkbox chk_vacation_module"/>
              <label for="radio101" class="css-label css-label-check radGroup1 radGroup2" style="margin-bottom: 15px !important;"><span class="form-title">Shop Vacation</span>
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
                        <input type='text' id="start_date_v_module" name="start_date_v_module" class="form-control vacation_datepicker1" value="" style="cursor:pointer;width: 101% !important;"/>
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
                  <p id="datepairExample1">
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
                <div class="col-md-12 col-xs-12 margin_bottom_30 cls_v_div">
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
              <div class="col-xs-2 cls-chk cls_radio_btn" style="border-right: 1px solid lightgrey;">
                <input type="radio" name="radio_day" id="radio7" class="css-checkbox radio_day" onclick="ChangeWorkingDay('1');" checked value="1"/>
                <label for="radio7" class="css-label  radGroup1 radGroup2">
                  <span>Daily</span>
                </label>
                <input type="radio" name="radio_day" id="radio8" class="css-checkbox radio_day" onclick="ChangeWorkingDay('2');" value="2"/>
                <label for="radio8" class="css-label  radGroup1 radGroup2">
                  <span>Weekly</span>
                </label>
                <!-- <input type="radio" name="radio_day" id="radio9" class="css-checkbox radio_day" onclick="ChangeWorkingDay('3');" value="3"/>
                <label for="radio9" class="css-label  radGroup1 radGroup2">
                  <span>Monthly</span>
                </label>
                <input type="radio" name="radio_day" id="radio10" class="css-checkbox radio_day" onclick="ChangeWorkingDay('4');" value="4"/>
                <label for="radio10" class="css-label  radGroup1 radGroup2">
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
              <?php foreach ($business_hours as $key => $hours) {?>
                <div class="business_hrs cls-business_hrs<?=$hours->id?>">
                  <div class="col-md-12 col-xs-12">
                    <div class="col-md-6 col-xs-12 business_hrs_inner">
                      <img src="<?=base_url()?>front/images/cal_blck.png">
                      <span><?=$hours->hours_day?></span>
                    </div>
                    <div class="col-md-6 col-xs-12 business_hrs_inner">
                      <img src="<?=base_url()?>front/images/clock.png">
                      <span><?=date("g:i A", strtotime($hours->from_time))?> --- <?=date("g:i A", strtotime($hours->to_time))?></span>
                    </div>
                  </div>
                  <a href="javascript:void(0)" class="btn_add btn_add_img">
                      <img src="<?=base_url()?>front/images/close.png" class="close cls-hours-id" data-image-id="<?=$hours->id?>" data-day="<?=$hours->hours_day?>">
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
            <div class="col-md-12 col-xs-12 cls_breaks">
              <hr class="hr_line margin_bottom_30">
            </div>
            <div class="col-md-12 center_btn_main">
              <div class="center_btn_sub">
                <div class="center_btn_subitem">
                  <button type="button" class="dlt_shop_btn" onclick="delete_shop();">Delete Shop</button>
                </div>
                <div class="center_btn_subitem">
                  <button type="submit" class="save_shop_btn">Save Changes</button>
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
$(document).ready(function(){
$("#city").multiselect({
header: ['checkAll','uncheckAll'],
});
});
</script>

<script type="text/javascript">
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
  $('#datepairExample_breaks1 .time').timepicker({
      'showDuration': true,
      'timeFormat': 'g:i A'
  });
  $('#datepairExample_breaks1').datepair();
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
                          scrollTop: $('.radio_policy').offset().top
                      }, 'slow');
                })
            }
         },
         error: function () {
         }
     });
    });
    $('.input-group-addon1').on('click', function() {
      $(this).prev('.vacation_datepicker2').data('DateTimePicker').toggle();
    // $('.vacation_datepicker1').data('DateTimePicker').toggle();
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
                 scrollTop: $('.radio_policy').offset().top
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
                   scrollTop: $('.radio_policy').offset().top
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
                            scrollTop: $('.radio_policy').offset().top
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

 $(document).on('click', ".save_shop_btn", function () {

     if($(".cls_vacation_module").is(':visible')){
       var starttime = $('#start_date_v_module').val();
       var endtime = $('#end_date_v_module').val();

       if(starttime == ''){
         swal({
               title: "",
               text: "Please select vacation start date",

           }, function () {
             $('html, body').animate({
                     scrollTop: $('.radio_policy').offset().top
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
                     scrollTop: $('.radio_policy').offset().top
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
<script type="text/javascript">
$('.cls_all_service').prop('checked', true);
<?php if(!empty($business_hours)){?>
        $('#cls-day-time').hide();
<?php }else{?>
        $('.img_business').attr('src','<?php echo base_url(); ?>front/images/delete.png');
<?php }?>
</script>

<script type="text/javascript">
$('#OpenImgUpload1').click(function() { $('#imgupload1').trigger('click'); });
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
$(document).ready(function(){
var _URL = window.URL || window.webkitURL;
$(document).on('change', "#imgupload1", function () {
 $('.css_title').css('margin-bottom', '0px');
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
    $('.css_title').css('margin-bottom', '50px');
    error += "Please select only gif, png, jpg or jpeg file"
 }
 if (imageSize > 2097152) {
   $('.css_title').css('margin-bottom', '50px');
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


<script type="text/javascript">
  function delete_shop() {
    var shop_id  = $('#shop_id').val();
    window.location.href = '<?php echo base_url(); ?>shop/delete_shop/'+shop_id;
  }
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('#OpenImgUpload').click(function() { $('#imgupload').trigger('click'); });

 $(document).on('change', "#imgupload", function () {
  var files = $('#imgupload')[0].files;
  var shop_id  = $('#shop_id').val();
  var error = '';
  var form_data = new FormData();

  for(var count = 0; count<files.length; count++)
  {
   var name = files[count].name;
   var imageSize = files[count].size;
   var extension = name.split('.').pop().toLowerCase();
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
   {
    error += "Please select only gif, png, jpg or jpeg file"
   }
   else if (imageSize > 2097152) {
     error += "Please select image size less than 2 MB"
   }
   else
   {
    form_data.append("files[]", files[count]);
   }
  }

  if(error == '')
  {
   $.ajax({
    url:"<?php echo base_url(); ?>shop/upload/"+shop_id,
    method:"POST",
    data:form_data,
    contentType:false,
    cache:false,
    processData:false,
    success:function(data)
    {
    var data1 = JSON.parse(data);
      for (var i = 0; i < data1.length; i++) {
          $('#uploaded_images').append('<div class="col-md-4 col-xs-12 image_preview_item img_item'+data1[i].id+'"><img src="<?php echo base_url();?>assets/uploads/shop_image/'+data1[i].image+'" class="img-responsive"><img src="<?php echo base_url()?>front/images/close.png" class="close image_delete" data-image-id="'+data1[i].id+'"></div>');
      }
     $('#imgupload').val('');
    }
   })
  }
  else
  {
    swal({
          title: "",
          text: error,

      }, function () {
      })
  }
 });
});
</script>


<script type="text/javascript">
$(document).ready(function(){
  $(document).on('click', ".image_delete", function () {
  // $('.image_delete').click(function() {
    var img_id = $(this).attr('data-image-id');

    swal({
      title: "Are you sure?",
      text: "You want to delete this image",
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
          url: "<?php echo base_url(); ?>shop/delete_image",
          type: 'post',
          data: {img_id:img_id},
          success: function (data) {
            $( ".img_item"+img_id ).remove();
            // swal("Deleted!", "Your image has been deleted.", "success");
          },
        });
      } else {
        // swal("Cancelled", "image not deleted", "error");
      }
    });
  });
});
</script>

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
          url: "<?php echo base_url(); ?>shop/delete_breaks_time",
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
      // for (var j = 1; j <= 7; j++) {
      //   var get_day = $('#service_day'+j).val();
      //   var n = Blank_Arr.includes(get_day);
      //   if(n == true){
      //     $('#service_day'+j).prop("checked", false);
      //   }
      // }
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
