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
            <h2>Add User</h2>
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
                    <form enctype="multipart/form-data" method="post" class="form-horizontal" id="frm_user" name="frm_user" data-toggle="validator" action="<?php echo site_url("User/add_user"); ?>">
                      <div class="col-md-8 col-xs-12">
                       <div class="item form-group">
                         <label class="control-label1 col-xs-12" for="product">First name</label><br>
                          <div class="col-xs-12">
                            <input id="fname" class="form-control col-md-7 col-xs-12" name="fname" type="text">
                          </div>
                        </div>
                        <div class="item form-group">
                          <label class="control-label1 col-xs-12" for="product">Last name</label><br>
                           <div class="col-xs-12">
                             <input id="lname" class="form-control col-md-7 col-xs-12" name="lname" type="text">
                           </div>
                         </div>
                         <!-- <div class="item form-group">
                           <label class="control-label1 col-xs-12" for="product">Username</label><br>
                            <div class="col-xs-12">
                              <input id="uname" class="form-control col-md-7 col-xs-12" name="uname" type="text">
                            </div>
                          </div> -->
                         <div class="item form-group">
                           <label class="control-label1 col-xs-12" for="product">Email</label><br>
                            <div class="col-xs-12">
                              <input id="u_email" class="form-control col-md-7 col-xs-12" name="u_email" type="text">
                            </div>
                          </div>
                          <div class="item form-group">
                            <label class="control-label1 col-xs-12" for="product">Password</label><br>
                             <div class="col-xs-12">
                               <input id="pwd" class="form-control col-md-7 col-xs-12" name="pwd"  type="password">
                             </div>
                           </div>
                           <div class="item form-group">
                             <label class="control-label1 col-xs-12" for="product">Confirm Password</label><br>
                              <div class="col-xs-12">
                                <input id="c_pwd" class="form-control col-md-7 col-xs-12" name="c_pwd" type="password">
                              </div>
                            </div>
                            <div class="item form-group">
                              <label class="control-label1 col-xs-12" for="gender">Gender</label><br>
                              <div class="col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" id="radio_gender" name="radio_gender">
                                  <option value="1">Female</option>
                                  <option value="2">Male</option>
                                  <option value="3">Rather not say</option>
                                </select>
                              </div>
                            </div>
                            <div class="item form-group">
                               <div class="col-xs-12 cls-chk" id="cls-chk">
                                   <input type="radio" name="u_chk" id="u_chk" value="1" checked>Client
                                   <input type="radio" class="cls-chk-input" name="u_chk" id="u_chk" value="2">Professional
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

<script type="text/javascript">
$( document ).ready(function() {
  $('#radio_gender').editableSelect({ filter: true});
});
</script>
