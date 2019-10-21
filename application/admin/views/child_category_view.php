<?php
$this->load->view('templates/_include/admin_main_sidebar_view');
?>
<div class="right_col" role="main" style="min-height: 3787px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Category List</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>View Childcategory</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              <!-- <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a></li>
                  <li><a href="#">Settings 2</a></li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a></li> -->
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
              <div class="col-md-12"><a class="btn btn-success col-md-3 pull-right" href="<?php echo site_url('category/add_child_category') ?>">Add child category</a></div>
              <table id="item-list" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Parent Category</th>
                    <th>Sub Category</th>
                    <th>Child Category</th>
                    <th>Action</th>
                 </tr>
               </thead>
              <tbody>
                  <?php foreach ($category_list as $key => $value) { ?>
                    <?php if(@$value->child_category->cat_name != '-' && !empty($value->parent_category->cat_name) && !empty($value->sub_category->cat_name)){ ?>
                    <tr id="row_<?=$value->category_id?>">
                    <td><?php if(isset($value->parent_category->cat_name)){ echo @$value->parent_category->cat_name;}?></td>
                    <td><?php if(isset($value->sub_category->cat_name)){ echo @$value->sub_category->cat_name;}?></td>
                    <td><?php if(isset($value->child_category->cat_name)){ echo @$value->child_category->cat_name;}?></td>
                    <td>
                      <button type="button" name="button" class="cls-btn-active-class btn cls_edit_btn"  data-encrypt-id="<?=$value->category_id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >Edit</button>
                      <button type="button" name="button" class="cls-btn-active-class btn cls_delete_btn"  data-user-id="<?=$value->category_id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" onclick="ChildcategoryConfirmDelete('<?=$value->category_id?>')" id="<?=$value->category_id?>">Delete</button>

                      <button type="button" name="button" class="cls-btn-active-class btn cls_private_btn btn_active<?=$value->category_id?> <?php if($value->permission == 2){ echo 'price-filter-active';}?>"  data-cat-id="<?=$value->category_id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;"><?php if($value->permission == 1){ echo 'Public';}else{ echo 'Private';}?></button>

                      <!-- <a href="<?=site_url()?>category/edit_child_category/<?=$value->category_id?>"><i class="fa fa-pencil"></i></a> |
                      <a href="javascript:void(0)" onclick="ChildcategoryConfirmDelete('<?=$value->category_id?>')" data-original-title="View" id="<?=$value->category_id?>" data-toggle="tooltip"><i class="fa fa-remove"></i></a> -->
                    </td>
                    </tr>
                  <?php } ?>
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
$(document).ready(function() {
    $('#item-list').DataTable({
    "order": []
});

$(document).on('click', ".cls_edit_btn", function (e) {
  var cat_id = $(this).attr('data-encrypt-id');
  window.location.href = site_url + "category/edit_child_category/" + cat_id;
});

$(document).on('click', ".cls_private_btn", function (e) {
  if ($(this).hasClass("price-filter-active")) {
    var cat_id = $(this).attr('data-cat-id');
    $(this).removeClass("price-filter-active");
    var flag = 1;
    swal({
      title: "Are you sure?",
      text: "You want to public this category",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
            url: site_url + 'category/private_category',
            method: "POST",
            data: {id: cat_id, flag: flag},
            async: false,
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.success == 'success') {
                  // $(".btn_active"+ obj.id).css("background-color", "green");
                  $(".btn_active"+ obj.id).html('Public');
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Category was set to public</div>');
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
    var cat_id = $(this).attr('data-cat-id');
    $(this).addClass("price-filter-active");
    var flag = 2;
    swal({
      title: "Are you sure?",
      text: "You want to private this category",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: true,
      closeOnCancel: true
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
            url: site_url + 'category/private_category',
            method: "POST",
            data: {id: cat_id, flag: flag},
            async: false,
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.success == 'success') {
                  // $(".btn_active"+ obj.id).css("background-color", "red");
                  $(".btn_active"+ obj.id).html('Private');
                    // $('#row_' + obj.id).remove();
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>Category was set to private.</div>');
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
  }
});

});
</script>
<style type="text/css">
  .dataTables_paginate{
    cursor: pointer;
  }
</style>
