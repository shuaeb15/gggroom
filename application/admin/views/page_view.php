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
        <h3>page List</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>View Pages</h2>
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
                    <th>Name</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Action</th>
                 </tr>
               </thead>
              <tbody>
                <?php foreach ($page_list as $key => $value) {
                  $date = date("d-m-Y", strtotime($value->updated_at));?>
                  <tr>
                  <td><?=$value->name?></td>
                  <td><?=$value->title?></td>
                  <td><?=$value->description?></td>
                  <td><?=$date?></td>
                  <td>
                    <button type="button" name="button" class="cls-btn-active-class btn_active<?=$value->id?> btn cls_btn <?php if($value->is_active == 0){ echo 'price-filter-active';}?>"  data-page-id="<?=$value->id?>" style="<?php if($value->is_active == 1){ echo "background:green";}else{ echo "background:red";}?>;color:white;padding:5px 10px 5px 10px !important;width:70px;" ><?php if($value->is_active == 0){ echo 'Inactive';}else{ echo 'Active';}?></button>

                    <button type="button" name="button" class="cls-btn-active-class btn cls_edit_btn"  data-encrypt-id="<?=$value->encrypt_id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >Edit</button>

                    <!-- <a href="<?=site_url()?>page/edit_page/<?=$value->encrypt_id?>" class="cls_view_shop cls_view cls-view-1" style="background: #40E0D0;color: white !important;border-radius: 3px;">Edit</a> -->
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
  var service_id = $(this).attr('data-encrypt-id');
  window.location.href = site_url + "page/edit_page/" + service_id;
});

    $(document).on('click', ".cls_btn", function (e) {

      if ($(this).hasClass("price-filter-active")) {
        var page_id = $(this).attr('data-page-id');
        $(this).removeClass("price-filter-active");

        swal({
          title: "Are you sure?",
          text: "You want to activate this page",
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
                url: site_url + 'page/active_page_id',
                method: "POST",
                data: {id: page_id},
                async: false,
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.success == 'success') {
                      $(".btn_active"+ obj.id).css("background-color", "green");
                      $(".btn_active"+ obj.id).html('Active');
                        $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Page active successfully!</div>');
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
          text: "You want to inactive this page",
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
                url: site_url + 'page/inactive_page_id',
                method: "POST",
                data: {id: page_id},
                async: false,
                success: function (data) {
                    var obj = JSON.parse(data);
                    if (obj.success == 'success') {
                      $(".btn_active"+ obj.id).css("background-color", "red");
                      $(".btn_active"+ obj.id).html('Inactive');
                        $('#row_' + obj.id).remove();
                        $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Page was set to inactive.</div>');
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
    })
});
</script>
<style type="text/css">
  .dataTables_paginate{
    cursor: pointer;
  }
</style>
