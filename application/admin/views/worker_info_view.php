<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>

<style media="screen">

.cls_shop_info{
  height: 36px;
border-radius: 4px;
text-align: left;
/* border: solid 2px #008080; */
font-size: 14px;
background: #f3f3f3;
margin-left: 10px;
}
.cls_lable_info{
  margin-top: 8px;
    font-weight: 100;
}
.cls_main{
  margin-bottom: 10px;
}
.cls_breaks{
  border-radius: 4px;
text-align: left;
padding: 10px;
/* border: solid 2px #008080; */
font-size: 14px;
background: #f3f3f3;
margin-left: 10px;
}
@media only screen and (max-width:480px){
.cls_all_field{
      width:100%;
  }
  .cls_breaks {
    font-size: 12px;
    margin-left: 0px;
  }
}
</style>
<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Worker info</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>View Worker Info</h2>
            <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="col-md-12 cls_main">
              <div class="item form-group">
                <?php
                $img = @$worker_data->image;
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
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                  <img src="<?=$main_image?>" alt="" id="preview_image" title="" class="img-responsive" style="border-radius: 10px;" /><br>
                </div>
               </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line margin_bottom_30">
            </div>
            <input type="hidden" name="shop_id" id="shop_id" value="<?=$worker_data->id?>">
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Worker Name</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$worker_data->name?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Worker Email</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$worker_data->email?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Mobile No</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$worker_data->mobile?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Percentage</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$worker_data->percentage?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Shop</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$worker_data->shop_name?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-7 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Worker Vacation</label><br>
                 <div class="col-md-12 col-xs-12 margin_bottom_30 cls_breaks cls_all_field">
                   <?php if(!empty($vacation_module_data)){?>
                     <?php foreach ($vacation_module_data as $key => $vacation) {?>
                       <div class="business_hrs cls-business_hrs<?=$vacation->id?>">
                         <div class="col-md-12 col-xs-12">
                           <div class="col-md-6 business_hrs_inner">
                             <span><?=date("d F Y", strtotime($vacation->start_date))?> to <?=date("d F Y", strtotime($vacation->end_date))?></span>
                           </div>
                         </div>
                       </div>
                     <?php }?>
                   <?php }else{?>
                      <span>No vacation mode added</span>
                   <?php }?>
                 </div>
                </div>
              </div>
              <div class="col-md-7 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Business Hours</label><br>
                 <div class="col-md-12 col-xs-12 margin_bottom_30 cls_breaks cls_all_field">
                   <?php if(!empty($business_hours)){?>
                     <?php foreach ($business_hours as $key => $hours) {?>
                       <div class="business_hrs cls-business_hrs<?=$hours->id?>">
                         <div class="col-md-12 col-xs-12">
                           <div class="col-md-6 business_hrs_inner">
                             <span><?=$hours->worker_day?></span>
                           </div>
                           <div class="col-md-6 business_hrs_inner">
                             <span><?=date("g:i A", strtotime($hours->from_time))?> --- <?=date("g:i A", strtotime($hours->to_time))?></span>
                           </div>
                         </div>
                       </div>
                     <?php }?>
                   <?php }else{?>
                      <span>No time Added</span>
                   <?php }?>
                 </div>
                </div>
              </div>
              <div class="col-md-7 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Breaks</label><br>
                 <div class="col-md-12 col-xs-12 margin_bottom_30 cls_breaks cls_all_field">
                   <?php if(!empty($breaks)){?>
                   <?php foreach ($breaks as $key => $breaks_time) {?>
                     <div class="business_hrs breaks cls-breaks<?=$breaks_time->id?>">
                       <div class="col-md-12 col-xs-12">
                         <div class="col-md-6 business_hrs_inner">
                             <span><?=$breaks_time->day?></span>
                         </div>
                         <div class="col-md-6 business_hrs_inner">
                             <span><?=date("g:i A", strtotime($breaks_time->from_time))?> --- <?=date("g:i A", strtotime($breaks_time->to_time))?></span>
                         </div>
                       </div>
                     </div>
                 <?php }?>
               <?php }else{?>
                 <span>No time Added</span>
               <?php }?>
                 </div>
                 </div>
              </div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-3">
                    <input type="button" onclick="location.href = '<?php echo base_url(); ?>worker'" class="btn btn-primary" value="Cancel">
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
