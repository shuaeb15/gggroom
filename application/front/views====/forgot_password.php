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
                     <span class="form-title" style="margin-top:20px;">Forgot Your Password?</span>
                     <span class="sub-title text-center"> Enter your email address and will send you a code to reset your password</span>
                      <form action="<?php echo base_url();?>Login/reset_password" enctype="multipart/form-data" method="post" class="form-horizontal" id="forgot_form" name="forgot_form" data-toggle="validator">
                          <div class="form-group" style="width:50%; margin:0px auto; text-align:center;">
                              <label for="fname">Email <span class="cls_star">*</span></label>
                              <input type="text" class="form-control" placeholder="Enter Email Address" id="recovery_email" name="recovery_email" style="height:50px;">
                          </div>
                          <div class="form-group" style="text-align:center;">
                            <button type="submit"  class="btn btn-default full-width-btn rotate-btn" style="float:none;height: 100px !important;margin-top: 100px !important;width: 13% !important; transform: rotate(45deg);"><span>NEXT</span></button>
                        </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </section>
