<?php $this->load->view('templates/_include/header_view1');?>
<style media="screen">
  #register_user label{
    color:#fff;
  }
</style>
<br><br><br><br>
<div class="sign-body">
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
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default sign-body">
          <div class="panel-body" style="padding-top: 0px;margin-top: -35px;">
            <form action="<?php echo site_url("login/register_user"); ?>" enctype="multipart/form-data" method="post" class="form-horizontal" id="register_user" name="register_user" data-toggle="validator">
              <h3 style="text-align: center; color: white">SIGNUP</h3><br/>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="fname">First Name <span class="cls_star">*</span></label>
                  <input type="text" class="form-control " id="fname" name="fname" placeholder="First Name" value="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="lname">Last Name <span class="cls_star">*</span></label>
                  <input type="text" class="form-control " id="lname" name="lname">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="uname">User Name <span class="cls_star">*</span></label>
                  <input type="text" class="form-control " id="uname" name="uname">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="email">Mobile <span class="cls_star">*</span></label>
                  <input type="text" class="form-control" id="mobile" name="mobile">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="email">Email <span class="cls_star">*</span></label>
                  <input type="email" class="form-control " id="u_email" name="u_email">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="pwd">Password <span class="cls_star">*</span></label>
                  <input type="password" class="form-control " id="pwd" name="pwd">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="cpwd">Confirm Password <span class="cls_star">*</span></label>
                  <input type="password" class="form-control " id="c_pwd" name="c_pwd">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                <label for="gender">Gender <span class="cls_star">*</span></label>
                <select class="form-control" id="radio_gender" name="radio_gender">
                  <option value="1">Female</option>
                  <option value="2">Male</option>
                  <option value="3">Rather not say</option>
                </select>
              </div>
              </div>
              <div class="form-check" style="width: 20%;">
                  <label>
                      <input type="radio" name="u_chk" id="u_chk" checked value="1"> <span class="label-text">Client</span>
                  </label>
              </div>
              <div class="form-check">
                  <label>
                      <input type="radio" name="u_chk" id="u_chk" value="2"> <span class="label-text">Professional</span>
                  </label>
              </div>
              <div class="form-submit" style="margin-top:80px;">
          		    <button type="submit" class="btns btn-secondary btn-lg btn-block" id="send">Create Account</button>
          	  </div>
              <div class="sign-fb" style="">
	          	   <h5 style="color: white">OR</h5>
	          	   <span style="color:#fff;">By clicking "Create Account", you agree to our <a href="<?php echo base_url('terms'); ?>">Terms &amp; Conditions</a> and <a href="<?php echo base_url('terms'); ?>">Privacy Policy</a></span>
          	  </div>
              <div class="pass-forgot">
                <p class="terms-condition" style="color:#fff;">Click here to <a href="<?php echo base_url('login'); ?>">Login</a></p>
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
