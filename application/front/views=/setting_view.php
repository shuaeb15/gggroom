<?php $this->load->view('templates/_include/header_view1');  ?>
<style media="screen">

.sa-button-container button {
    width: auto !important;
    padding: 3px 16px !important;
  }
  .cls_save_btn{
    padding: 0px 12px;
  }
.cls-notification{
  box-shadow: 14px 0 73px rgba(91, 90, 90, 0.5);
  background: #fff;
  height: 60px;
  margin-bottom: 20px;
}
.cls_setting{
  margin-left: 100px;
  margin-right: 100px;
}
.cls_name{
  font-size: 26px;
color: rgba(0, 0, 0, 0.60);
float: left;
margin-top: 12px;
}
.proinbox_main{
  margin-top: 12px;
}
.cls_save_btn{
  width: 115px;
    background: #008080;
    color: white;
    font-size: 20px;
}
.cls_star{
  color: red;
}
.cls-slider{
  float: right;
  width: 30%;
  margin-top: -20px;
}

.cls_btn_back{
  float: right;
  font-size: 20px;
  color: #fff;
  background: #059797;
  border: none;
  height: auto;
  padding: 9px 30px;
  margin-top: 0px !important;
}
.cls_btn_back:hover{
color: #fff;
background: #059797;
}

@media only screen and (max-width:480px){
.cls-notification  {
    padding-right: 0px !important;
  }
  .cls_setting{
    margin-left: 0px;
    margin-right: 0px;
  }
  .cls_name{
    font-size: 23px;
  }
  .proinbox_main{
    margin-top: 0px !important;
  }
  .cls-slider{
    margin-left: 155px;
    margin-top: -30px;
  }
  .cls_btn_back{
    width: 100%;
  }
}
</style>
<?php $u_id = $this->session->userdata('uid');?>
<div class="related_services product_round">
   <div class="container">
     <div class="" style="margin-top: 35px;">
       <?php if ($this->session->flashdata('error_message')) { ?>
               <div class="alert alert-danger alert-dismissable">
                 <button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="width: auto;">×</button>
                 <?php echo $this->session->flashdata('error_message'); ?> </div>
       <?php } ?>
       <?php if ($this->session->flashdata('success_message')) { ?>
               <div class="alert alert-success alert-dismissable">
                 <button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="width: auto;">×</button>
               <?php echo $this->session->flashdata('success_message'); ?> </div>
       <?php } ?>
     </div>
     <div class="col-md-12" style="text-align:center;font-size: 35px;">
       <span class="" >Settings</span>
     </div>
      <div class="col-md-12 col-xs-12" style="text-align:center;background: #e5e5e5;padding: 10px 10px 10px 10px;margin-top: 20px;">
        <a href="<?php echo base_url();?>profile" class="btn btn-default cls_btn_back"><span>Go back</span></a>
         <div class="cls_setting">
           <div class="notification">
             <div class="col-md-12 col-xs-12" style="margin-top: 48px;">
                 <span class="form-title" style="font-weight: 400;font-size: 30px;float: left;">Notifications</span>
             </div>
             <input type="hidden" id="user_id" value="<?=$u_id?>">
             <div class="col-md-12 col-xs-12 cls-notification">
               <div class="col-md-11 col-xs-18">
                 <span class="cls_name">Messages </span>
               </div>
               <div class="col-md-1 col-xs-6 cls-slider">
                 <div class="proinbox_main">
                    <div class="form-group switch_title">
                       <label class="switch">
                       <input type="checkbox" <?php if($userlist->message_alert == '1'){ echo 'checked';}?> class="<?php if($userlist->message_alert == '1'){ echo 'messages_notification';}?>" id="messages_alert">
                       <span class="slider round"></span>
                       </label>
                    </div>
                 </div>
               </div>
             </div>
             <div class="col-md-12 col-xs-12 cls-notification">
               <div class="col-md-11 col-xs-18">
                 <span class="cls_name">Reminders</span>
               </div>
               <div class="col-md-1 col-xs-6 cls-slider">
                 <div class="proinbox_main">
                    <div class="form-group switch_title">
                       <label class="switch">
                       <input type="checkbox" <?php if($userlist->reminder_alert == '1'){ echo 'checked';}?> id="reminder_alert" class="<?php if($userlist->reminder_alert == '1'){ echo 'reminder_notification';}?>">
                       <span class="slider round"></span>
                       </label>
                    </div>
                 </div>
               </div>
             </div>
             <div class="col-md-12 col-xs-12 cls-notification">
               <div class="col-md-11 col-xs-18">
                 <span class="cls_name">Promotion & tips </span>
               </div>
               <div class="col-md-1 col-xs-6 cls-slider">
                 <div class="proinbox_main">
                    <div class="form-group switch_title">
                       <label class="switch">
                       <input type="checkbox" <?php if($userlist->tips_alert == '1'){ echo 'checked';}?> id="tips_alert" class="<?php if($userlist->tips_alert == '1'){ echo 'tips_notification';}?>">
                       <span class="slider round"></span>
                       </label>
                    </div>
                 </div>
               </div>
             </div>
           </div>
           <div class="preferences">
             <div class="col-md-12 col-xs-12">
                 <span class="form-title" style="font-weight: 400;font-size: 30px;">Preferences</span>
             </div>
             <div class="col-md-12 col-xs-12 cls-notification">
               <div class="col-md-11 col-xs-18">
                  <a href="javascript:void(0)" class="cls_default_card"><span class="cls_name">Default card </span></a>
               </div>
             </div>
             <div class="col-md-12 col-xs-12 cls-notification">
               <div class="col-md-11 col-xs-18">
                 <a href="<?php echo site_url();?>profile/change_email"><span class="cls_name">Update email </span></a>
               </div>
             </div>
             <div class="col-md-12 col-xs-12 cls-notification">
               <div class="col-md-11 col-xs-18">
                 <a href="<?php echo site_url();?>login/privacy"><span class="cls_name">Update password </span></a>
               </div>
             </div>
           </div>
           <div class="others">
             <div class="col-md-12 col-xs-12">
                 <span class="form-title" style="font-weight: 400;font-size: 30px;">Others</span>
             </div>
             <div class="col-md-12 col-xs-12 cls-notification">
               <div class="col-md-11 col-xs-18">
                 <a href="<?php echo site_url();?>help"><span class="cls_name">Get Help / FAQ </span></a>
               </div>
             </div>
             <div class="col-md-12 col-xs-12 cls-notification">
               <div class="col-md-11 col-xs-18">
                 <a href="<?php echo site_url();?>terms"><span class="cls_name">Read terms & conditions </span></a>
               </div>
             </div>
             <div class="col-md-12 col-xs-12 cls-notification">
               <div class="col-md-11 col-xs-18">
                 <a href="javascript:void(0)" class="cls_delete_profile"><span class="cls_name">Delete profile </span></a>
               </div>
             </div>
           </div>
         </div>
      </div>
   </div>
</div>


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Card Details</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url();?>setting/insert_card_detail" enctype="multipart/form-data" method="post" class="form-horizontal" id="default_card_form" name="default_card_form" data-toggle="validator">
            <div class="form-group">
                <label class="col-md-10" style="margin-left: 15px;">Card number <span class="cls_star">*</span></label>
                <div class="input-group col-md-12" style="padding: 0px 30px 0px 30px;">
                	<!-- <input class="form-control cls-time-input" name="test" type="text" > -->
                    <input class="form-control cls-time-input" id="card_number" name="card_number" type="text" value="<?=$userlist->card_no?>" style="font-weight: 100;color:#000 !important;border: solid 2px #008080 !important;">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-10" style="margin-left: 15px;">Cardholder's name <span class="cls_star">*</span></label>
                <div class="input-group col-md-12" style="padding: 0px 30px 0px 30px;">
                  <input class="form-control" id="card_name" name="card_name" type="text" value="<?=$userlist->card_name?>" style="font-weight: 100;color:#000 !important;border: solid 2px #008080 !important;">
                </div>
            </div>
            <div class="form-group">
              <div class="col-md-7">
                <label class="col-md-10">Expiry Date <span class="cls_star">*</span></label>
                <div class="input-group col-md-12" style="padding: 0px 15px 0px 15px;">
                  <div class='input-group date' id='datetimepicker1'>
                    <input type='text' id="exp_date" name="exp_date" class="form-control datetimepicker1" value="<?=$userlist->exp_date?>" style="font-weight: 100;color:#000 !important;border: solid 2px #008080 !important;"/>
                    <!-- <span class="input-group-addon">
                    <span class="fa fa-caret-down"></span>
                    </span> -->
                  </div>
                </div>
              </div>
              <!-- <div class="col-md-5">
                <label class="col-md-10">CVV <span class="cls_star">*</span></label>
                <div class="input-group col-md-12" style="padding: 0px 15px 0px 15px;">
                  <input class="form-control" id="card_cvv" name="card_cvv" type="text" value="<?=$userlist->cvv_no?>" style="font-weight: 100;color:#000 !important;border: solid 2px #008080 !important;">
                </div>
              </div> -->
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default save_shop_bt cls_save_btn">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
