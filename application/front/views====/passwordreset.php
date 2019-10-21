<?php $this->load->view('templates/_include/header_view1');?>
<style media="screen">
input.form-control{
    color:#000 !important;
    border: solid 2px #008080 !important;
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
                    <span class="form-title" style="margin-top:20px;">Reset Password</span>
                    <form id="reset_pwd_form" action="<?php echo site_url("login/password_reset/".$token); ?>" enctype="multipart/form-data" method="post" class="form-horizontal change_pwd_form" name="reset_pwd_form" data-toggle="validator">
                      <input type="hidden" name="forgot_token" id="forgot_token" value="<?php echo $token;?>">
                      <div class="form-group">
                           <label> <span class="label-text"> Password <span class="cls_star">*</span></span> </label>
                           <input type="password" class="form-control " id="pwd" name="pwd">
                      </div>
                      <div class="form-group">
                           <label> <span class="label-text">Confirm Password <span class="cls_star">*</span></span> </label>
                           <input type="password" class="form-control " id="c_pwd" name="c_pwd">
                      </div>
                      <div class="form-group" style="text-align:center;">
                        <button type="submit"  id="varification" class="btn btn-default full-width-btn rotate-btn" style="float:none;"><span>UPDATE</span></button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
