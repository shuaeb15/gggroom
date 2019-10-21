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
            <!-- <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a> -->
              <!-- <ul class="dropdown-menu" role="menu">
                <li><a href="#">Settings 1</a></li>
                <li><a href="#">Settings 2</a></li>
              </ul> -->
            <!-- </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li> -->
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
                    <form enctype="multipart/form-data" method="post" class="form-horizontal" id="edit_frm_user" name="edit_frm_user" data-toggle="validator" action="<?php echo site_url("User/update_user"); ?>">
                      <input type="hidden" id="user_id" name="user_id" value="<?php if(isset($userlist->id)){ echo $userlist->id;}?>">
                      <div class="col-md-8 col-xs-12">
                       <div class="item form-group">
                         <label class="control-label1 col-xs-12" for="product">First name</label><br>
                          <div class="col-xs-12">
                            <input id="fname" class="form-control col-md-7 col-xs-12" name="fname" type="text" value="<?php if(isset($userlist->firstname)){ echo $userlist->firstname;}?>">
                          </div>
                        </div>
                        <div class="item form-group">
                          <label class="control-label1 col-xs-12" for="product">Last name</label><br>
                           <div class="col-xs-12">
                             <input id="lname" class="form-control col-md-7 col-xs-12" name="lname" type="text" value="<?php if(isset($userlist->lastname)){ echo $userlist->lastname;}?>">
                           </div>
                         </div>
                         <!-- <div class="item form-group">
                           <label class="control-label1 col-xs-12" for="product">Username</label><br>
                            <div class="col-xs-12">
                              <input id="uname" class="form-control col-md-7 col-xs-12" name="uname" type="text" value="<?php if(isset($userlist->username)){ echo $userlist->username;}?>">
                            </div>
                          </div> -->
                         <div class="item form-group">
                           <label class="control-label1 col-xs-12" for="product">Email</label><br>
                            <div class="col-xs-12">
                              <input id="u_email" class="form-control col-md-7 col-xs-12" name="u_email" type="text" value="<?php if(isset($userlist->email)){ echo $userlist->email;}?>">
                            </div>
                          </div>
                          <div class="item form-group">
                            <label class="control-label1 col-xs-12" for="gender">Gender</label><br>
                            <div class="col-xs-12">
                              <select class="form-control col-md-7 col-xs-12" id="radio_gender" name="radio_gender">
                                <option <?php if($userlist->gender == '1'){ echo 'selected';}?> value="1">Female</option>
                                <option <?php if($userlist->gender == '2'){ echo 'selected';}?> value="2">Male</option>
                                <option <?php if($userlist->gender == '3'){ echo 'selected';}?> value="3">Rather not say</option>
                              </select>
                            </div>
                          </div>
                          <?php if(isset($userlist->u_category)){
                            $u_cat = $userlist->u_category;
                          }else{
                            $u_cat = '';
                          }?>
                            <div class="item form-group">
                               <div class="col-xs-12 cls-chk">
                                 <label>
                                   <input type="radio" name="u_chk" id="u_chk" value="1" <?php if($u_cat == '1'){ echo 'checked';}?>>Client</input>
                                 </label>
                                 <label>
                                   <input type="radio" class="cls-chk-input" name="u_chk" id="u_chk" value="2" <?php if($u_cat == '2'){ echo 'checked';}?>>Professional</input>
                                 </label>
                                 <?php if($u_cat == '3'){?>
                                   <label>
                                     <input type="radio" class="cls-chk-input" name="u_chk" id="u_chk" value="3" <?php if($u_cat == '3'){ echo 'checked';}?>>Worker</input>
                                   </label>
                                 <?php }?>
                               </div>
                             </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-3">
                            <input type="button" onclick="location.href = '<?php echo base_url(); ?>User'" class="btn btn-primary" value="Cancel">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
    $("input:checkbox").on('click', function() {
      var $box = $(this);
      if ($box.is(":checked")) {
        var group = "input:checkbox[name='" + $box.attr("name") + "']";
        $(group).prop("checked", false);
        $box.prop("checked", true);
      } else {
        $box.prop("checked", false);
      }
    });
</script>

<script type="text/javascript">
$( document ).ready(function() {
  $('#radio_gender').editableSelect({ filter: true});
});
</script>
