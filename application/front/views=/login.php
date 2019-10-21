<?php $this->load->view('templates/_include/header_view1');?>
<style media="screen">
  .error{
    color: #FF0000;
  }
  input[type=checkbox].css-checkbox+label.css-label, input[type=checkbox].css-checkbox+label.css-label.clr {
    line-height: 20px !important;
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
          <div class="panel-body">
            <form action="<?php echo site_url("login/user_login");?>" enctype="multipart/form-data" method="post" class="form-horizontal" id="login_user" name="login_user" data-toggle="validator">
              <h3 style="text-align: center; color: white">LOGIN</h3><br/>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Email" name="uname" id="uname1" value="<?php if(isset($_COOKIE['rem_email'])){ echo $_COOKIE['rem_email'];}?>">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <input type="password" class="form-control" placeholder="Password" name="pwd" id="pwd" value="<?php if(isset($_COOKIE['rem_pass'])){ echo $_COOKIE['rem_pass'];}?>">
                  <!-- <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span> -->
                </div>
                <div class="col-md-12" style="float:left; margin-top:20px;">
                  <span class="keep-log">
                    <!-- <input type="checkbox" id="service_day2" class="css-checkbox cls_all_service" value="Tuesday" checked>
                    <label for="service_day2" class="css-label css-label-check dayCB">Tuesday</label> -->

                     <input type="checkbox" name="remember" id="remember" class="css-checkbox cls_all_service" <?php if(isset($_COOKIE['remember'])){?>checked<?php }?>>
                     <label for="remember"  class="keep-label css-label css-label-check">Keep me signed here</label>
                   </span>
                 </div>
              </div>
              <div class="form-submit">
          		    <button type="submit" class="btns btn-secondary btn-lg btn-block">SUBMIT</button>
          	  </div>
          	  <div class="pass-forgot" style="">
	          	   <h5 style="color: white">OR</h5>
	          	   <a href="#" style="color: white">Google Login &nbsp; |&nbsp;</a>  <a href="#" style="color: white">Facebook Login</a>
          	  </div>
          	  <div class="pass-forgot">
                <a href="<?php echo site_url("register");?>" style="color: white">Create Account &nbsp; |&nbsp;</a> <a href="<?php echo site_url("login/forgot_password");?>" style="color: white">Forgot Password</a>
          	  </div>
  		    </form>
         </div>
       </div>
     </div>
   </div>
  </div>
</div>
