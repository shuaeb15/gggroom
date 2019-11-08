<?php
$this->load->view('templates/_include/admin_main_sidebar_view');
?>
<style media="screen">
.cls-view-1{
    padding: 9px 18px 9px 14px !important;
}
.cls-edit-1{
padding: 9px 18px 9px 14px !important;
}

@media only screen and (max-width:480px){
  .x_content{
    overflow: auto;
  }
  .cls-td{
      height: 131px;
  }

  .cls-btn-active-class{
      margin-bottom: 16px;
  }
  .cls-view-1{
      padding: 9px 18px 9px 25px !important;
  }
  .cls-edit-1{
    margin-left: -70px !important;
  padding: 8px 22px 8px 25px !important;
  margin-top: 32px;
  position: absolute;
  }
}
</style>

<div class="right_col" role="main" style="min-height: 3787px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Appointment List</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>View Appointments</h2>
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
              <table id="item-list" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Shop name</th>
                    <th>Worker name</th>
                    <th>Service name</th>
                    <th>Start time</th>
                    <th>End time</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="width: 230px;">Action</th>
                    <!-- <<th></th>>Action</th> -->
                 </tr>
               </thead>
              <tbody>
                  <?php foreach ($appointment_list as $key => $value) {
                    $from_time = date("g:i A", strtotime($value->from_time));
                    $to_time = date("g:i A", strtotime($value->to_time));
                    $date = date("d-m-Y", strtotime($value->created_at)) ;

                    if($value->booking_status == 0){
                        $booking_status = 'Pending';
                    }else if($value->booking_status == 1){
                        $booking_status = 'Confirmed';
                    }else if($value->booking_status == 2){
                        $booking_status = 'Finished';
                    }else if($value->booking_status == 3){
                        $booking_status = 'Canceled';
                    }
                    ?>
                    <tr>
                    <td><?=$value->user->firstname?> <?=$value->user->lastname?></td>
                    <td><?=$value->shop->shop_name?></td>
                    <td><?=$value->worker->name?></td>
                    <td><?=$value->service_name?></td>
                    <td><?=$from_time?></td>
                    <td><?=$to_time?></td>
                    <td><?=$date?></td>
                    <td><?php if(isset($value->price->price)){ echo '$'.$value->price->price;}?></td>
                    <td><?=$booking_status?></td>
                    <td style="padding-top: 15px;padding-bottom: 15px;">
                      <?php 
                      if($admin_data[0]['user_promotion'] != 1){
                             if(!empty($user_access_data)){
                              if($user_access_data[0]['u_delete'] == 1){?>
                                <button type="button" name="button" class="cls-btn-active-class btn_active<?=$value->id?> btn cls_btn <?php if($value->is_deleted == 1){ echo 'price-filter-active';}?>"  data-appointment-id="<?=$value->id?>" style="<?php if($value->is_deleted == 0){ echo "background:green;padding:5px 14px !important";}else{ echo "background:red;padding:5px 10px !important";}?>;color:white;" ><?php if($value->is_deleted == 1){ echo 'Cancel';}else{ echo 'Active';}?></button>
                      <?php }}}else{?>
                                <button type="button" name="button" class="cls-btn-active-class btn_active<?=$value->id?> btn cls_btn <?php if($value->is_deleted == 1){ echo 'price-filter-active';}?>"  data-appointment-id="<?=$value->id?>" style="<?php if($value->is_deleted == 0){ echo "background:green;padding:5px 14px !important";}else{ echo "background:red;padding:5px 10px !important";}?>;color:white;" ><?php if($value->is_deleted == 1){ echo 'Cancel';}else{ echo 'Active';}?></button>
                      <?php }?>
                              <button type="button" name="button" class="cls-btn-active-class btn cls_view_btn"  data-encrypt-id="<?=$value->encrypt_id?>" style="padding:5px 17px !important;background: #40E0D0;border-radius:3px;border:none;color:white;" >View</button>
                      <?php if($admin_data[0]['user_promotion'] != 1){
                             if(!empty($user_access_data)){
                              if($user_access_data[0]['u_edit'] == 1){?>
                              <button type="button" name="button" class="cls-btn-active-class btn cls_edit_btn"  data-encrypt-id="<?=$value->encrypt_id?>" style="padding:5px 17px !important;background: #40E0D0;border-radius:3px;border:none;color:white;" >Edit</button>
                      <?php }}}else{?>
                              <button type="button" name="button" class="cls-btn-active-class btn cls_edit_btn"  data-encrypt-id="<?=$value->encrypt_id?>" style="padding:5px 17px !important;background: #40E0D0;border-radius:3px;border:none;color:white;" >Edit</button>
                      <?php }?>
                      <?php if($value->booking_status == 0){?>
                              <button type="button" name="button" class="cls-btn-active-class btn_pending" id="btn_pending<?=$value->id?>" data-appointment-id="<?=$value->id?>" style="padding:5px 17px !important;background: #40E0D0;border-radius:3px;border:none;color:white;" >Pending</button>
                      <?php }?>

                       <?php if($value->refund_request == 'yes'){?>
                              <button type="button" name="button" class="cls-btn-active-class btn_refund" id="btn_refund<?=$value->id?>" data-appointment-id="<?=$value->id?>" style="padding:5px 17px !important;background: #40E0D0;border-radius:3px;border:none;color:white;" >Refund Request</button>
                      <?php }?>
                      <?php if($value->refund == 'yes'){?>
                              <button type="button" name="button" class="cls-btn-active-class "  data-appointment-id="<?=$value->id?>" style="padding:5px 17px !important;background: #40E0D0;border-radius:3px;border:none;color:white;" >Refund Complete</button>
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

<script type="text/javascript">
  var site_url = $("#site_url").val();
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#item-list').DataTable({
    "order": []
});


$(document).on('click', ".cls_view_btn", function (e) {
  var service_id = $(this).attr('data-encrypt-id');
  window.location.href = site_url + "appointment/appointment_info/" + service_id;
});

$(document).on('click', ".cls_edit_btn", function (e) {
  var service_id = $(this).attr('data-encrypt-id');
  window.location.href = site_url + "appointment/edit_appointment/" + service_id;
});

$(document).on('click', ".cls_btn", function (e) {
// $('.btn').on("click", function() {
  // alert('in');
  if ($(this).hasClass("price-filter-active")) {
    var appointment_id = $(this).attr('data-appointment-id');
    if(appointment_id == undefined){
        var appointment_id = '';
    }else{
      var appointment_id = appointment_id;
    }
    $(this).removeClass("price-filter-active");
    swal({
      title: "Are you sure?",
      text: "You want to activate this appointment",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Yes, activate",
      cancelButtonText: "No, cancel",
      closeOnConfirm: true,
      closeOnCancel: true,
   html: false
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
            url: site_url + 'appointment/active_appointment',
            method: "POST",
            data: {id: appointment_id},
            async: false,
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(obj);
                // swal.close();
                if (obj.success == 'success') {
                  swal("", "appointment activate", "success");
                  $(".btn_active"+ obj.id).css("background-color", "green");
                  $(".btn_active"+ obj.id).html('Active');
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Appointment active Successfully!</div>');

                }
                else if (obj.unsuccess == 'unsuccess') {
                  swal("", "appointment activate", "unsuccess");
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                } else {
                  swal("", "appointment activate", "");
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
                // window.location.href = '<?php echo base_url();?>service';
            }

        });
      } else {
        swal("Cancelled", "not activate", "error");
      }
    });

  } else {
    var appointment_id = $(this).attr('data-appointment-id');
    if(appointment_id == undefined){
        var appointment_id = '';
    }else{
      var appointment_id = appointment_id;
    }
    $(this).addClass("price-filter-active");
    swal({
      title: "Are you sure?",
      text: "You want to cancel this appointment",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: true,
      closeOnCancel: true,
   html: false
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
            url: site_url + 'appointment/inactive_appointment',
            method: "POST",
            data: {id: appointment_id},
            async: false,
            success: function (data) {
              console.log(data);
                var obj = JSON.parse(data);
                // swal.close();
                if (obj.success == 'success') {
                  // swal("", "appointment cancel", "success");
                  $(".btn_active"+ obj.id).css("background-color", "red");
                  $(".btn_active"+ obj.id).html('Cancel');
                    $('#row_' + obj.id).remove();
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Appointment was set to cancel.</div>');
                }
                else if (obj.unsuccess == 'unsuccess') {
                  // swal("", "appointment inactive", "unsuccess");
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                } else {
                  swal("", "appointment inactive", "");
                    $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                }
                // window.location.href = '<?php echo base_url();?>service';
            }
        });
      } else {
        // swal("Cancelled", "not cancel", "error");
      }
    });


    // }
  }
});
    $('.cls_finished').on("click", function() {

        var appointment_id = $(this).attr('data-appointment-id');

        swal({
          title: "Are you sure?",
          text: "You want to finished this appointment",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-success",
          confirmButtonText: "Yes, finished",
          cancelButtonText: "No, cancel",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm) {
          if (isConfirm) {
            $.ajax({
                url: site_url + 'appointment/finished_appointment',
                method: "POST",
                data: {id: appointment_id},
                async: false,
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.success == 'success') {
                      // swal("", "appointment finished", "success");
                        $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Appointment finish Successfully!</div>');

                    }
                    else if (obj.unsuccess == 'unsuccess') {
                        $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                    } else {
                        $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                    }
                }
            });
          } else {
            // swal("Cancelled", "not finished", "error");
          }
        });
    });

    $(document).on('click', ".btn_pending", function (e) {
    var appointment_id = $(this).attr('data-appointment-id');
      swal({
        title: "Are you sure?",
        text: "You want to confirm this appointment",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Yes, confirm",
        cancelButtonText: "No, cancel",
        closeOnConfirm: true,
        closeOnCancel: true,
     html: false
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajax({
              url: site_url + 'appointment/confirm_appointment',
              method: "POST",
              data: {id: appointment_id},
              async: false,
              success: function (data) {
                  var obj = JSON.parse(data);
                  console.log(obj);
                  $('#btn_pending'+appointment_id).hide();
                  if (obj.success == 'success') {
                    swal("", "appointment activate", "success");
                      $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Appointment confirm Successfully!</div>');
                  }
                  else if (obj.unsuccess == 'unsuccess') {
                    swal("", "appointment activate", "unsuccess");
                      $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                  } else {
                    swal("", "appointment activate", "");
                      $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                  }
              }
          });
        } else {
          swal("Cancelled", "not activate", "error");
        }
      });
    });


     $(document).on('click', ".btn_refund", function (e) {
    var appointment_id = $(this).attr('data-appointment-id');
      swal({
        title: "Are you sure?",
        text: "You want to Refund this",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Yes, confirm",
        cancelButtonText: "No, cancel",
        closeOnConfirm: true,
        closeOnCancel: true,
     html: false
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajax({
              url: site_url + 'appointment/refund_appointment',
              method: "POST",
              data: {id: appointment_id},
              async: false,
              success: function (data) {
                  var obj = JSON.parse(data);
                  console.log(obj);
                  $('#btn_pending'+appointment_id).hide();
                  if (obj.success == 'success') {
                    swal("", "appointment activate", "success");
                      $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Refund confirm Successfully!</div>');
                  }
                  else if (obj.unsuccess == 'unsuccess') {
                    swal("", "appointment activate", "unsuccess");
                      $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                  } else {
                    swal("", "appointment activate", "");
                      $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                  }
              }
          });
        } else {
          swal("Cancelled", "not refund", "error");
        }
      });
    });

});

</script>
<style type="text/css">
  .dataTables_paginate{
    cursor: pointer;
  }
</style>
