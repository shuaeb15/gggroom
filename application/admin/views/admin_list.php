<?php
$this->load->view('templates/_include/admin_main_sidebar_view');
?>
<style media="screen">
.cls-view-1{
    padding: 9px 18px 9px 14px !important;
}
.btn-add-user{
  padding: 6px 12px;
  font-size: 14px;
  margin-bottom: 10px;
  text-align: center;
  border-radius: 4px;
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
        <h3>User List</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>View Users</h2>
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
            <div class="col-md-12"><a class="btn-success col-md-3 pull-right btn-add-user" href="<?php echo site_url('admin/add_user') ?>">Add User</a></div>
              <table id="item-list" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Permission</th>
                    <th>Action</th>
                 </tr>
               </thead>
              <tbody>
                <?php
                // echo '<pre>';print_r($admin_list);exit;
                foreach ($admin_list as $key => $value) {?>
                  <tr id="row_<?=$value->id?>">
                  <td><?=$value->firstname?></td>
                  <td><?=$value->lastname?></td>
                  <td><?=$value->email?></td>
                  <td><?=$value->role_name?></td>
                  <td><?php foreach ($value->permission as $key => $per){
                    if($per->u_add == 1){
                      $add = 'Add';
                    }else{
                      $add = '';
                    }
                    if($per->u_edit == 1){
                      $edit = 'Edit';
                    }else{
                      $edit = '';
                    }
                    if($per->u_delete == 1){
                      $delete = 'Delete';
                    }else{
                      $delete = '';
                    }
                    if($add != '' && $edit != '' && $delete != ''){
                      $permission = $add.', '.$edit.', '.$delete;
                    }else if($add != '' && $edit != '' && $delete == ''){
                      $permission = $add.', '.$edit;
                    }else if($add != '' && $edit == '' && $delete != ''){
                      $permission = $add.', '.$delete;
                    }else if($add != '' && $edit == '' && $delete == ''){
                      $permission = $add;
                    }else if($add == '' && $edit != '' && $delete == ''){
                      $permission = $edit;
                    }else if($add == '' && $edit == '' && $delete != ''){
                      $permission = $delete;
                    }else if($add == '' && $edit != '' && $delete != ''){
                      $permission = $edit.', '.$delete;
                    }
                    else{
                      $permission = '';
                    }
                    echo ucfirst($per->module_name).': '.$permission. '<br/>';
                    ?>

                  <?php }?></td>
                  <td>
                    <button type="button" name="button" class="cls-btn-active-class btn cls_edit_btn"  data-encrypt-id="<?=$value->encrypt_id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >Edit</button>
                    <button type="button" name="button" class="cls-btn-active-class btn cls_delete_btn"  data-user-id="<?=$value->id?>" style="padding:5px 10px 5px 10px !important;width:70px;background: #40E0D0;border-radius:3px;border:none;color:white;" >Delete</button>
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
} );

$(document).on('click', ".cls_edit_btn", function (e) {
  var user_id = $(this).attr('data-encrypt-id');
  window.location.href = site_url + "admin/edit_user/" + user_id;
});

$(document).on('click', ".cls_delete_btn", function (e) {
    var user_id = $(this).attr('data-user-id');
    swal({
      title: "Are you sure?",
      text: "You want to delete this user",
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
            url: site_url + 'admin/remove_user',
            method: "POST",
            data: {id: user_id},
            async: false,
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.success == 'success') {
                    $('#row_' + obj.id).remove();
                    $('.res').html('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>User deleted successfully.</div>');
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


});
</script>
<style type="text/css">
  .dataTables_paginate{
    cursor: pointer;
  }
</style>
