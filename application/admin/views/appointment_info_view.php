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
@media only screen and (max-width:480px){
.cls_all_field{
      width:100%;
  }
}
</style>
<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Appointment info</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>View Appointment Info</h2>
            <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <?php
          if(isset($appointment_list->from_time)){
              $from = $appointment_list->from_time;
          }else{
              $from = '';
          }
          if(isset($appointment_list->to_time)){
              $to = $appointment_list->to_time;
          }else{
              $to = '';
          }
          if(isset($appointment_list->ap_date)){
              $create_date = $appointment_list->ap_date;
          }else{
              $create_date = '';
          }
          if(isset($appointment_list->booking_status)){
            if($appointment_list->booking_status == 0){
                $booking_status = 'Pending';
            }else if($appointment_list->booking_status == 1){
                $booking_status = 'Confirmed';
            }else if($appointment_list->booking_status == 2){
                $booking_status = 'Finished';
            }else if($appointment_list->booking_status == 3){
                $booking_status = 'Canceled';
            }
          }else{
              $booking_status = '';
          }

          $from_time = date("g:i A", strtotime($from));
          $to_time = date("g:i A", strtotime($to));
          $date = date("d-m-Y", strtotime($create_date));

          ?>
          <div class="x_content">
            <div class="col-md-12 cls_main">
              <div class="item form-group">
                <?php
                if(isset($appointment_list->service->service_image)){
                    $img = $appointment_list->service->service_image;
                }
                else{
                  $img= '';
                }
                $temp_file = base_url()."../front/images/banner.jpg";
                $main_file = "../assets/uploads/service_image/".$img;
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
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">User</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?php if(isset($appointment_list->user->firstname)){ echo $appointment_list->user->firstname;}?> <?php if(isset($appointment_list->user->lastname)){ echo $appointment_list->user->lastname;}?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Shop name</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?php if(isset($appointment_list->shop->shop_name)){ echo $appointment_list->shop->shop_name;}?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Worker name</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?php if(isset($appointment_list->worker->name)){ echo $appointment_list->worker->name;}?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Service name</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?php if(isset($appointment_list->service_name)){ echo $appointment_list->service_name;}?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Start time</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$from_time?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">End time</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$to_time?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Date</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$date?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Status</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?=$booking_status?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Order id</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?php if(isset($appointment_list->order_id)){ echo $appointment_list->order_id;}?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Transaction id</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <?php if(!empty($appointment_list->order)){
                            $transaction_id = $appointment_list->order->transaction_id;
                    }else{
                        $transaction_id = '';
                    }?>
                    <label class="cls_lable_info"><?=$transaction_id?></label><br>
                  </div>
                 </div>
              </div>
              <div class="col-md-6 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Price</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <label class="cls_lable_info"><?php if(isset($appointment_list->price->price)){ echo '$'.$appointment_list->price->price;}?></label><br>
                  </div>
                 </div>
              </div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <input type="button" onclick="location.href = '<?php echo base_url(); ?>appointment'" class="btn btn-primary" value="Back to list">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
