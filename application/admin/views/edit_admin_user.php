<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>
<style media="screen">
@media only screen and (max-width:480px){
.cls-chk {
    font-size: 20px !important;
  }
}
</style>
<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>User</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit User</h2>
            <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <?php if ($this->session->flashdata('error_message')) { ?>
          <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <?php echo $this->session->flashdata('error_message'); ?> </div>
              <?php } ?>
              <?php if ($this->session->flashdata('success_message')) { ?>
              <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                  <?php echo $this->session->flashdata('success_message'); ?> </div>
                    <?php } ?>
                  <div class="x_content">
                    <form enctype="multipart/form-data" method="post" class="form-horizontal" id="edit_admin_user" name="edit_admin_user" data-toggle="validator" action="<?php echo site_url("admin/update_user"); ?>">
                      <input type="hidden" id="user_id" name="user_id" value="<?php if(isset($admin_list->id)){ echo $admin_list->id;}?>">
                      <input type="hidden" id="user_access_id" name="user_access_id" value="<?php if(isset($admin_list->user_promotion)){ echo $admin_list->user_promotion;}?>">
                      <div class="col-md-8 col-xs-12">
                       <div class="item form-group">
                         <label class="control-label1 col-xs-12" for="product">First name</label><br>
                          <div class="col-xs-12">
                            <input id="fname" class="form-control col-md-7 col-xs-12" name="fname" type="text" value="<?php if(isset($admin_list->firstname)){ echo $admin_list->firstname;}?>">
                          </div>
                        </div>
                        <div class="item form-group">
                          <label class="control-label1 col-xs-12" for="product">Last name</label><br>
                           <div class="col-xs-12">
                             <input id="lname" class="form-control col-md-7 col-xs-12" name="lname" type="text" value="<?php if(isset($admin_list->lastname)){ echo $admin_list->lastname;}?>">
                           </div>
                         </div>
                         <div class="item form-group">
                           <label class="control-label1 col-xs-12" for="product">Email</label><br>
                            <div class="col-xs-12">
                              <input id="u_email" class="form-control col-md-7 col-xs-12" name="u_email" type="text" value="<?php if(isset($admin_list->email)){ echo $admin_list->email;}?>">
                            </div>
                          </div>
                          <div class="item form-group">
                            <label class="control-label1 col-xs-12" for="product">Role</label><br>
                             <div class="col-xs-12">
                               <select class="form-control col-md-7 col-xs-12" name="user_role" id="user_role">
                                  <option value="">Select</option>
                                  <?php
                                    foreach ($role_list as $role){?>
                                        <option <?php if($admin_list->user_promotion == $role->id){ echo 'selected';}?> value="<?=$role->id?>"><?=ucfirst($role->role_name)?></option>
                                  <?php }?>
                               </select>
                             </div>
                           </div>
                           <div class="item form-group">
                             <!-- <label class="control-label1 col-md-12">Modules</label><br> -->
                             <label class="control-label1 col-md-3">Permissions</label>
                             <label class="control-label1 col-md-1">Add</label>
                             <label class="control-label1 col-md-1">Edit</label>
                             <label class="control-label1 col-md-1">Delete</label>
                             <?php foreach ($module_list as $key => $value){?>
                               <div class="col-md-12 cls_<?=$value->id?>">
                                 <div class="col-md-3 cls-md-2">
                                   <input type="checkbox" name="u_<?=$value->id?>" id="u_<?=$value->id?>" value="<?=$value->id?>" <?php foreach($user_module_list as $j){if($j->module_id == $value->id){?>checked<?php }}?>> <?=ucfirst($value->module_name)?>
                                 </div>
                                 <div class="col-md-1">
                                   <input type="checkbox" name="u_<?=$value->id?>_1" id="u_<?=$value->id?>_1" <?php foreach($user_module_list as $j){if($j->module_id == $value->id){if($j->u_add == 1){?>checked<?php }}}?>>
                                 </div>
                                 <div class="col-md-1">
                                   <input type="checkbox" name="u_<?=$value->id?>_2" id="u_<?=$value->id?>_2" <?php foreach($user_module_list as $j){if($j->module_id == $value->id){if($j->u_edit == 1){?>checked<?php }}}?>>
                                 </div>
                                 <div class="col-md-1">
                                   <input type="checkbox" name="u_<?=$value->id?>_3" id="u_<?=$value->id?>_3" <?php foreach($user_module_list as $j){if($j->module_id == $value->id){if($j->u_delete == 1){?>checked<?php }}}?>>
                                 </div>
                               </div>
                             <?php }?>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-3">
                            <input type="button" onclick="location.href = '<?php echo base_url(); ?>admin'" class="btn btn-primary" value="Cancel">
                            <button id="send" type="submit" class="btn btn-success">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
      var role = $('#user_role').val();
      if(role == 1){
        $("#u_1").prop("checked", true);
        $("#u_1_1").prop("checked", true);
        $("#u_1_2").prop("checked", true);
        $("#u_1_3").prop("checked", true);
      }

      if($('input[name="u_1"]').prop('checked')){
        $(".cls_2").hide();
        $(".cls_3").hide();
        $(".cls_4").hide();
        $(".cls_5").hide();
        $(".cls_6").hide();
        $(".cls_7").hide();
      }
      $('input[name="u_1"]').click(function(){
            if($(this).prop("checked") == true){
              $("#u_1_1").prop("checked", true);
              $("#u_1_2").prop("checked", true);
              $("#u_1_3").prop("checked", true);
              $(".cls_2").hide();
              $(".cls_3").hide();
              $(".cls_4").hide();
              $(".cls_5").hide();
              $(".cls_6").hide();
              $(".cls_7").hide();
            }else{
              $("#u_1_1").prop("checked", false);
              $("#u_1_2").prop("checked", false);
              $("#u_1_3").prop("checked", false);
              $(".cls_2").show();
              $(".cls_3").show();
              $(".cls_4").show();
              $(".cls_5").show();
              $(".cls_6").show();
              $(".cls_7").show();
            }
      });

      var user_role = $('#user_access_id').val();
      if(user_role == 1){
        $("#u_1").attr('disabled', true);
        $("#u_1_1").attr('disabled', true);
        $("#u_1_2").attr('disabled', true);
        $("#u_1_3").attr('disabled', true);
        $('.cls_1').show();
        $(".cls_2").hide();
        $(".cls_3").hide();
        $(".cls_4").hide();
        $(".cls_5").hide();
        $(".cls_6").hide();
        $(".cls_7").hide();
      }
      if(user_role == 2){
        if($('input[name="u_1"]').prop('checked')){
          $("#u_1_1").attr('disabled', true);
          $("#u_1_2").attr('disabled', true);
          $("#u_1_3").attr('disabled', true);
          $('.cls_1').show();
          $(".cls_2").hide();
          $(".cls_3").hide();
          $(".cls_4").hide();
          $(".cls_5").hide();
          $(".cls_6").hide();
          $(".cls_7").hide();
        }else{
          $('.cls_1').show();
          $(".cls_2").show();
          $(".cls_3").show();
          $(".cls_4").show();
          $(".cls_5").show();
          $(".cls_6").show();
          $(".cls_7").show();
        }
      }
      if(user_role == 3){
        $('.cls_1').hide();
        $(".cls_2").hide();
        $(".cls_3").show();
        $(".cls_4").hide();
        $(".cls_5").hide();
        $(".cls_6").hide();
        $(".cls_7").show();
      }

      $(document).on('change', "#user_role", function () {
        $("#u_1").prop("checked", false);
        $("#u_1_1").prop("checked", false);
        $("#u_1_2").prop("checked", false);
        $("#u_1_3").prop("checked", false);
        $("#u_2").prop("checked", false);
        $("#u_2_1").prop("checked", false);
        $("#u_2_2").prop("checked", false);
        $("#u_2_3").prop("checked", false);
        $("#u_3").prop("checked", false);
        $("#u_3_1").prop("checked", false);
        $("#u_3_2").prop("checked", false);
        $("#u_3_3").prop("checked", false);
        $("#u_4").prop("checked", false);
        $("#u_4_1").prop("checked", false);
        $("#u_4_2").prop("checked", false);
        $("#u_4_3").prop("checked", false);
        $("#u_5").prop("checked", false);
        $("#u_5_1").prop("checked", false);
        $("#u_5_2").prop("checked", false);
        $("#u_5_3").prop("checked", false);
        $("#u_6").prop("checked", false);
        $("#u_6_1").prop("checked", false);
        $("#u_6_2").prop("checked", false);
        $("#u_6_3").prop("checked", false);
        $("#u_7").prop("checked", false);
        $("#u_7_1").prop("checked", false);
        $("#u_7_2").prop("checked", false);
        $("#u_7_3").prop("checked", false);
          var user_role = $('#user_role').val();
          if(user_role == 1){
            $("#u_1").attr('disabled', true);
            $("#u_1_1").attr('disabled', true);
            $("#u_1_2").attr('disabled', true);
            $("#u_1_3").attr('disabled', true);
            $("#u_1").prop("checked", true);
            $("#u_1_1").prop("checked", true);
            $("#u_1_2").prop("checked", true);
            $("#u_1_3").prop("checked", true);
            $('.cls_1').show();
            $(".cls_2").hide();
            $(".cls_3").hide();
            $(".cls_4").hide();
            $(".cls_5").hide();
            $(".cls_6").hide();
            $(".cls_7").hide();
          }
          if(user_role == 2){
            $("#u_1").attr('disabled', false);
            $("#u_1_1").attr('disabled', true);
            $("#u_1_2").attr('disabled', true);
            $("#u_1_3").attr('disabled', true);
            $("#u_1").prop("checked", false);
            $("#u_1_1").prop("checked", false);
            $("#u_1_2").prop("checked", false);
            $("#u_1_3").prop("checked", false);
            $('.cls_1').show();
            $(".cls_2").show();
            $(".cls_3").show();
            $(".cls_4").show();
            $(".cls_5").show();
            $(".cls_6").show();
            $(".cls_7").show();
          }
          if(user_role == 3){
            $("#u_1").attr('disabled', false);
            $("#u_1").prop("checked", false);
            $("#u_1_1").prop("checked", false);
            $("#u_1_2").prop("checked", false);
            $("#u_1_3").prop("checked", false);
            $('.cls_1').hide();
            $(".cls_2").hide();
            $(".cls_3").show();
            $(".cls_4").hide();
            $(".cls_5").hide();
            $(".cls_6").hide();
            $(".cls_7").show();
          }
      });
    });
</script>
