<?php $this->load->view('templates/_include/header_view1');?>
<style media="screen">
input.form-control{
    color:#000 !important;
    border: solid 2px #008080 !important;
  }
  .rotate-btn{
    float: none;
    margin-right: 50px !important;
    height: 100px !important;
    width: 100px;
    transform: rotate(45deg);
  }
</style>
<section class="block">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <div class="signup-form">
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
                    <span class="form-title" style="margin-top:20px;">Change Password</span>
                    <form id="change_pwd_form" action="<?php echo site_url("login/change_password"); ?>" enctype="multipart/form-data" method="post" class="form-horizontal change_pwd_form" name="change_pwd_form" data-toggle="validator">
                      <div class="form-group">
                           <label> <span class="label-text">Current Password <span class="cls_star">*</span></span> </label>
                           <input type="password" class="form-control " id="current_pwd" name="current_pwd">
                      </div>
                      <div class="form-group">
                           <label> <span class="label-text"> Password <span class="cls_star">*</span></span> </label>
                           <input type="password" class="form-control " id="pwd" name="pwd">
                      </div>
                      <div class="form-group">
                           <label> <span class="label-text">Confirm Password <span class="cls_star">*</span></span> </label>
                           <input type="password" class="form-control " id="c_pwd" name="c_pwd">
                      </div>
                      <div class="form-group" style="text-align:center;">
                        <a href="<?php echo base_url();?>setting" class="btn btn-default full-width-btn rotate-btn" style="float:none;margin-right: 50px !important;"><span style="margin-top: 30px;">BACK</span></a>
                        <button type="submit"  class="btn btn-default full-width-btn rotate-btn" style="float:none;"><span>UPDATE</span></button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
