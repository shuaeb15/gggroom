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
  .x_content{
    overflow: auto;
  }
}
</style>
<div class="right_col" role="main" style="min-height: 3787px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Worker List</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>View Workers</h2>
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
                    <th>Worker name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Action</th>
                 </tr>
               </thead>
              <tbody>
                  <?php foreach ($worker_list as $key => $value) {?>
                    <tr id="row_<?=$value->id?>">
                    <td><?php if(isset($value->user->firstname)){ echo $value->user->firstname;}?> <?php if(isset($value->user->lastname)){ echo $value->user->lastname;}?></td>
                    <td><?php if(isset($value->name)){ echo $value->name;}?></td>
                    <td><?php if(isset($value->email)){ echo $value->email;}?></td>
                    <td><?php if(isset($value->mobile)){ echo $value->mobile;}?></td>
                    <td class="cls-td">
                      <?php if($admin_data[0]['user_promotion'] != 1){
                              if(!empty($user_access_data)){
                                if($user_access_data[0]['u_delete'] == 1){?>
                                  <button type="button" name="button" class="cls-btn-active-class btn_active<?=$value->id?> btn cls_btn <?php if($value->is_active == 0){ echo 'price-filter-active';}?>"  data-worker-id="<?=$value->id?>" style="<?php if($value->is_active == 1){ echo "background:green";}else{ echo "background:red";}?>;color:white;padding:5px 10px 5px 10px !important;width:70px;" ><?php if($value->is_active == 0){ echo 'Inactive';}else{ echo 'Active';}?></button>
                      <?php }}}else{?>
                                <button type="button" name="button" class="cls-btn-active-class btn_active<?=$value->id?> btn cls_btn <?php if($value->is_active == 0){ echo 'price-filter-active';}?>"  data-worker-id="<?=$value->id?>" style="<?php if($value->is_active == 1){ echo "background:green";}else{ echo "background:red";}?>;color:white;padding:5px 10px 5px 10px !important;width:70px;" ><?php if($value->is_active == 0){ echo 'Inactive';}else{ echo 'Active';}?></button>
                      <?php }?>
                            <button type="button" name="button" class="cls-btn-active-class btn cls_view_btn"  data-encrypt-id="<?=$value->encrypt_id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >View</button>
                      <?php if($admin_data[0]['user_promotion'] != 1){
                              if(!empty($user_access_data)){
                                if($user_access_data[0]['u_edit'] == 1){?>
                                  <button type="button" name="button" class="cls-btn-active-class btn cls_edit_btn"  data-encrypt-id="<?=$value->encrypt_id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >Edit</button>
                              <?php }?>
                              <?php if($user_access_data[0]['u_delete'] == 1){?>
                                  <button type="button" name="button" class="cls-btn-active-class btn cls_delete_btn"  data-worker-id="<?=$value->id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >Delete</button>
                     <?php }}}else{?>
                                <button type="button" name="button" class="cls-btn-active-class btn cls_edit_btn"  data-encrypt-id="<?=$value->encrypt_id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >Edit</button>
                                <button type="button" name="button" class="cls-btn-active-class btn cls_delete_btn"  data-worker-id="<?=$value->id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >Delete</button>
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
  window.location.href = site_url + "worker/worker_info/" + service_id;
});

$(document).on('click', ".cls_edit_btn", function (e) {
  var service_id = $(this).attr('data-encrypt-id');
  window.location.href = site_url + "worker/edit_worker/" + service_id;
});

$(document).on('click', ".cls_delete_btn", function (e) {
var worker_id = $(this).attr('data-worker-id');

swal({
  title: "Are you sure?",
  text: "You want to delete this worker",
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
        url: site_url + 'worker/remove_worker',
        method: "POST",
        data: {id: worker_id},
        async: false,
        success: function (data) {
            var obj = JSON.parse(data);
            if (obj.success == 'success') {
                $('#row_' + obj.id).remove();
                $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Worker deleted successfully.</div>');
            }
            else if (obj.unsuccess == 'unsuccess') {
                $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

            } else {
                $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
            }
        }
    });
  }
});
});

    $(document).on('click', ".cls_btn", function (e) {

      if ($(this).hasClass("price-filter-active")) {
        var worker_id = $(this).attr('data-worker-id');
        $(this).removeClass("price-filter-active");

        swal({
          title: "Are you sure?",
          text: "You want to activate this worker",
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
                url: site_url + 'worker/active_user_id',
                method: "POST",
                data: {id: worker_id},
                async: false,
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.success == 'success') {
                      // swal("", "shop activate", "success");
                      $(".btn_active"+ obj.id).css("background-color", "green");
                      $(".btn_active"+ obj.id).html('Active');
                        $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Worker active successfully!</div>');

                    }
                    else if (obj.unsuccess == 'unsuccess') {
                        $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                    } else {
                        $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                    }
                }
            });
          } else {
            // swal("Cancelled", "not activate", "error");
          }
        });
      } else {
        var worker_id = $(this).attr('data-worker-id');
        $(this).addClass("price-filter-active");

        swal({
          title: "Are you sure?",
          text: "You want to inactive this worker",
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
                url: site_url + 'worker/inactive_user_id',
                method: "POST",
                data: {id: worker_id},
                async: false,
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.success == 'success') {
                      // swal("", "Shop inactive", "success");
                      $(".btn_active"+ obj.id).css("background-color", "red");
                      $(".btn_active"+ obj.id).html('Inactive');
                        $('#row_' + obj.id).remove();
                        $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Worker was set to inactive.</div>');
                    }
                    else if (obj.unsuccess == 'unsuccess') {
                        $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>unsuccessfully!</div>');

                    } else {
                        $('.res').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Something went wrong!</div>');
                    }
                }
            });
          } else {
            // swal("Cancelled", "not inactive", "error");
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
