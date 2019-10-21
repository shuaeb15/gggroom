<?php
$this->load->view('templates/_include/admin_main_sidebar_view');
?>
<style media="screen">
.cls-view-1{
    padding: 9px 18px 9px 14px !important;
}
p{
  font-size: 13px !important;
}
@media only screen and (max-width:480px){
  .cls-view-1{
      padding: 9px 18px 9px 25px !important;
  }
  .x_content{
    overflow: auto;
  }
}
</style>
<div class="right_col" role="main" style="min-height: 3787px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Offers List</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>View Offers</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
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
          <div class="x_content">
            <div class="res"></div>
            <?php if($admin_data[0]['user_promotion'] != 1){
                    if(!empty($user_access_data)){
                      if($user_access_data[0]['u_add'] == 1){?>
                        <div class="col-md-12"><a class="btn btn-success col-md-3 pull-right" href="<?php echo site_url('offers/add_offers') ?>">Add offers</a></div>
            <?php }}}else{?>
                      <div class="col-md-12"><a class="btn btn-success col-md-3 pull-right" href="<?php echo site_url('offers/add_offers') ?>">Add offers</a></div>
            <?php }?>
              <table id="item-list" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Discount Type</th>
                    <th>Price</th>
                    <th>Offer Type</th>
                    <th>Service name</th>
                    <th>Date</th>
                    <th>Action</th>
                 </tr>
               </thead>
              <tbody>
                <?php foreach ($offers_list as $key => $value) {
                  $date = date("d-m-Y", strtotime($value->created_at));
                  if($value->offer_type == 1){
                      $offer_type = 'General Offer';
                  }else if($value->offer_type == 2){
                      $offer_type = 'Service Offer';
                  }else{
                      $offer_type = '';
                  }

                  if($value->discount_type == 1){
                      $discount_type = 'Percent discount';
                  }else if($value->discount_type == 2){
                      $discount_type = 'Fixed amount';
                  }else{
                    $discount_type = '';
                  }
                  if(!empty($value->service_name)){
                      $service_name = $value->service_name.' - '.$value->shop_name;
                  }else{
                    $service_name = '';
                  }

                  ?>
                  <tr>
                  <td><?=$value->code?></td>
                  <td><?=$discount_type?></td>
                  <td><?=$value->price?></td>
                  <td><?=$offer_type?></td>
                  <td><?=$service_name?></td>
                  <td><?=$date?></td>
                  <td>
                    <?php if($admin_data[0]['user_promotion'] != 1){
                            if(!empty($user_access_data)){
                              if($user_access_data[0]['u_delete'] == 1){?>
                                <button type="button" name="button" class="cls-btn-active-class btn_active<?=$value->id?> btn_main <?php if($value->is_active == 0){ echo 'price-filter-active';}?>"  data-page-id="<?=$value->id?>" style="<?php if($value->is_active == 1){ echo "background:green";}else{ echo "background:red";}?>;color:white;padding:5px 10px 5px 10px !important;width:70px;" ><?php if($value->is_active == 0){ echo 'Inactive';}else{ echo 'Active';}?></button>
                    <?php }}}else{?>
                              <button type="button" name="button" class="cls-btn-active-class btn_active<?=$value->id?> btn_main <?php if($value->is_active == 0){ echo 'price-filter-active';}?>"  data-page-id="<?=$value->id?>" style="<?php if($value->is_active == 1){ echo "background:green";}else{ echo "background:red";}?>;color:white;padding:5px 10px 5px 10px !important;width:70px;" ><?php if($value->is_active == 0){ echo 'Inactive';}else{ echo 'Active';}?></button>
                    <?php }?>
                    <?php if($admin_data[0]['user_promotion'] != 1){
                            if(!empty($user_access_data)){
                              if($user_access_data[0]['u_edit'] == 1){?>
                                <button type="button" name="button" class="cls-btn-active-class btn cls_edit_btn"  data-encrypt-id="<?=$value->encrypt_id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >Edit</button>
                   <?php }}}else{?>
                              <button type="button" name="button" class="cls-btn-active-class btn cls_edit_btn"  data-encrypt-id="<?=$value->encrypt_id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >Edit</button>
                   <?php }?>
                   </td>
                  </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<script type="text/javascript">
  var site_url = $("#site_url").val();
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#item-list').DataTable({
    "order": []
});

$(document).on('click', ".cls_edit_btn", function (e) {
  var offer_id = $(this).attr('data-encrypt-id');
  window.location.href = site_url + "offers/edit_offers/" + offer_id;
});

$(document).on('click', ".btn_main", function (e) {
  if ($(this).hasClass("price-filter-active")) {
    var page_id = $(this).attr('data-page-id');
    $(this).removeClass("price-filter-active");

    swal({
      title: "Are you sure?",
      text: "You want to activate this offer",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Yes, activate",
      cancelButtonText: "No, cancel",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
            url: site_url + 'offers/active_offers_id',
            method: "POST",
            data: {id: page_id},
            async: false,
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.success == 'success') {
                  $(".btn_active"+ obj.id).css("background-color", "green");
                  $(".btn_active"+ obj.id).html('Active');
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Offer active successfully!</div>');
                }
                else if (obj.unsuccess == 'unsuccess') {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                } else {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
            }
        });
      } else {
      }
    });
  } else {
    var page_id = $(this).attr('data-page-id');
    $(this).addClass("price-filter-active");

    swal({
      title: "Are you sure?",
      text: "You want to inactive this offer",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, inactive",
      cancelButtonText: "No, cancel",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
            url: site_url + 'offers/inactive_offers_id',
            method: "POST",
            data: {id: page_id},
            async: false,
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.success == 'success') {
                  $(".btn_active"+ obj.id).css("background-color", "red");
                  $(".btn_active"+ obj.id).html('Inactive');
                    $('#row_' + obj.id).remove();
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Offer was set to inactive.</div>');
                }
                else if (obj.unsuccess == 'unsuccess') {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                } else {
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
            }
        });
      } else {
      }
    });
  }
});    
});
</script>
<style type="text/css">
  .dataTables_paginate{
    cursor: pointer;
  }
</style>
