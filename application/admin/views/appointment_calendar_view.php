<?php
$this->load->view('templates/_include/admin_main_sidebar_view');
?>
<style media="screen">
.fc-center{
  font-size: 25px !important;
}
.cls_btn_back{
  float: left;
font-size: 20px;
color: #fff;
background: #059797;
border: none;
height: auto;
padding: 9px 92px;
}
.cls_btn_back:hover{
color: #fff;
background: #059797;
}
.emboss-btn{
  width: 100%;
text-align: center;
color: #fff;
font-size: 20px;
background: #059797;
margin: 15px 0;
}
.fc-event-container .fc-draggable{
  background-color: #299494 !important;
    border-color: #299494 !important;
    color: #FFF !important;
}
.fc-content{
  background-color: #299494 !important;
    border-color: #299494 !important;
    color: #FFF !important;
    cursor: pointer;
}

.WorkerData{
  width: -webkit-fill-available;
    height: 35px;
    border-color: #ddd;
    border-radius: 0px;
    color: #059797;
    text-transform: none;
    border-width: 2px;
    text-align: left;
    font-size: 14px;
    background: #fff;
}

/* button.active{
    background: #059797;
    color: #fff !important;
    border-color: #059797;
} */

.WorkerData:hover{
    background: #059797;
    color: #fff !important;
    border-color: #059797;
}

.employee_lable{
  width: 100%;
text-align: center;
color: #fff;
font-size: 20px;
background: #059797;
margin: 15px 0;
padding: 6px 12px;
font-weight: 100;
}
#event_title{
  width: 100%;
    /* margin-left: 76px !important; */
    /* text-align: center; */
    /* color: #059797; */
    font-size: 20px;
    /* background: #059797; */
    margin: 15px 0;
    padding: 6px 12px;
    font-weight: 100;
}

@media only screen and (max-width:480px){
  .cls_btn_back{
    width: 100%;
  }
}
</style>
<div class="right_col" role="main" style="min-height: 959px;">
  <div class="res" style="margin-top:70px;">
  <?php if ($this->session->flashdata('error_message')) { ?>
    <div class="alert alert-danger alert-dismissable">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
      <?php echo $this->session->flashdata('error_message'); ?> </div>
  <?php }?>
  <?php if ($this->session->flashdata('success_message')) { ?>
    <div class="alert alert-success alert-dismissable">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
      <?php echo $this->session->flashdata('success_message'); ?> </div>
  <?php }?>
    </div>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Appointment</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;padding-bottom: 50px;">
        <div class="col-xs-12 col-sm-6 col-md-5 col-md-offset-4 col-sm-offset-3">
          <div id="" class="input-group custom_drpdwn" style="width: 100%;">
            <select class="form-control" id="AllshopDropDown" style="height: 50px;border-radius: 0; text-align: left; border: solid 2px #008080; font-weight: 500; color: #000; font-size: 20px; background-color: transparent; appearance: none; -moz-appearance: none; -webkit-appearance: none;cursor: pointer;">
              <option value="">All Shops</option>
              <?php foreach ($ShopData as $value) { ?>
                  <option value="<?php echo $value['id']; ?>"><?php echo $value['shop_name']; ?></option>
              <?php } ?>
            </select>
            <span class="input-group-addon CalDropD" style="position: absolute; height: 50px; width: 45px; right: 0;"><span class="fa fa-caret-down"></span></span>
          </div>
       </div>
     </div>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <label class="employee_lable">Employee</label>
          <!-- <button type="button" class="btn btn-default full-width-btn emboss-btn">Employee</button> -->
          <div class="service_category">
            <div class="btn-group-maincat WorkerDiv" data-toggle="buttons-radio">
              <?php foreach ($WorkersData as $worker) { ?>
                <button type="button" class="btn WorkerData full-width-btn" data-id="<?php echo $worker->id; ?>"><?php echo $worker->name; ?></button>
              <?php } ?>
            </div>
          </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-9">
          <div id='calendar'></div>
      </div>
      </div>
    </div>
</div>
<!--- Event Model Popup start --->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-calendar-o "> Appointment </i></h4>
          </div>
          <form class="" action="<?=site_url()?>calendar/update_appointment/" method="post">
          <div class="modal-body">
            <div class="form-group" style="background: lightgrey;">
              <div class="col-md-12" style="margin-top:10px;">
                <label for="event_title" class="col-md-3 control-label">Edit appointment</label>
              </div>
              <div class="input-group">
                    <label id="event_title" name="event_title"></label>
                    <input type="hidden" name="appointment_id" id="appointment_id" value="">
                    <input type="hidden" name="main_date" id="main_date" value="">
                    <?php if($admin_data[0]['user_promotion'] != 1){
                           if(!empty($user_access_data)){
                            if($user_access_data[0]['u_edit'] == 1){?>
                              <div class="col-md-12 cls_main">
                                <div class="item form-group col-md-4">
                                  <label>Date <span class="cls_star">*</span></label>
                                  <div class='input-group date' id='datetimepicker1'>
                                     <input type='text' name="ap_date" id="ap_date" class="form-control datetimepicker1" value="" style="cursor:pointer;"/>
                                     <span class="input-group-addon" style="cursor:pointer;">
                                     <span class="fa fa-caret-down"></span>
                                     </span>
                                  </div>
                                 </div>
                              </div>
                              <div class="col-md-7 cls_main">
                                <div class="item form-group">
                                  <label style="margin-left: 10px;">Start Time <span class="cls_star">*</span></label><br>
                                  <input type="text" class="time start ui-timepicker-input cls-time-input" id="start_time" name="start_time" value="" style="margin-left: 10px;order: 1px solid #ccc;padding: 6px 12px;font-size: 14px;">
                                </div>
                              </div>
                  <?php }}}else{?>
                    <div class="col-md-12 cls_main">
                      <div class="item form-group col-md-4">
                        <label>Date <span class="cls_star">*</span></label>
                        <div class='input-group date' id='datetimepicker1'>
                           <input type='text' name="ap_date" id="ap_date" class="form-control datetimepicker1" value="" style="cursor:pointer;"/>
                           <span class="input-group-addon" style="cursor:pointer;">
                           <span class="fa fa-caret-down"></span>
                           </span>
                        </div>
                       </div>
                    </div>
                    <div class="col-md-7 cls_main">
                      <div class="item form-group">
                        <label style="margin-left: 10px;">Start Time <span class="cls_star">*</span></label><br>
                        <input type="text" class="time start ui-timepicker-input cls-time-input" id="start_time" name="start_time" value="" style="margin-left: 10px;order: 1px solid #ccc;padding: 6px 12px;font-size: 14px;">
                      </div>
                    </div>
                  <?php }?>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <?php if($admin_data[0]['user_promotion'] != 1){
                    if(!empty($user_access_data)){
                      if($user_access_data[0]['u_edit'] == 1){?>
                        <button type="submit" class="btn btn-primary edit_ap_btn">Update</button>
                    <?php }?>
                    <?php if($user_access_data[0]['u_delete'] == 1){?>
                      <button type="button" class="btn btn-primary delete_btn">Delete</button>
                    <?php }}}else{?>
                      <button type="submit" class="btn btn-primary edit_ap_btn">Update</button>
                      <button type="button" class="btn btn-primary delete_btn">Delete</button>
            <?php }?>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!-- <div id="fc_edit" data-toggle="modal" data-target="#myModal"></div> -->
    <script type="text/javascript">
        $(document).ready(function($) {
          $('#calendar').fullCalendar({
          eventClick: function(calEvent, jsEvent, view) {
            var main_event = calEvent.title;
            var user_name = calEvent.user;
            var user_email = calEvent.email;
            var user_mobile = calEvent.mobile;
            var service_name = calEvent.service;
            var ap_date = calEvent.ap_date;
            var ap_id = calEvent.ap_id;
            var start_time = calEvent.ap_start;

            $('#appointment_id').val(ap_id);
            $('#ap_date').val(ap_date);
            $('#main_date').val(ap_date);
            $('#start_time').val(start_time);

            var html = '<p style="font-size: 25px;color: #059797;">'+service_name +'</p><p>' + user_name +'</p><p>' + user_email +'</p><p>' + user_mobile +'</p><p>' + main_event+'</p>';
            // alert(main_email);
             $('#myModal').modal('show');
             $('#event_title').html(html);
          }
          });
        });

        $(document).on('focusout', "#ap_date", function () {
          var ap_date1 = $('#main_date').val();
          var ap_date2 = $('#ap_date').val();

          if(ap_date1 != ap_date2){
            $('#start_time').val('');
          }
        });
    </script>
