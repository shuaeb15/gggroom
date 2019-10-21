<?php $this->load->view('templates/_include/header_view1');?>
<style media="screen">
.circle-varification{
  border-bottom:none !important;
}
.rotate-btn{
  margin-left: 321px !important;
}
@media only screen and (max-width:480px){
.rotate-btn{
  margin-left: 104px !important;
 }
 #varification .number-area {
    width: 70px;
    height: 70px;
  }
}
</style>
<?php if($this->session->userdata('uid')){?>
<li class="dropdown">
  <a class="test" tabindex="-1" href="#" data-toggle="dropdown">Hi, <?php echo $this->session->userdata('firstname');?> <span class="caret"></span></a>
  <ul class="dropdown-menu">
    <li><a href="#" class="active-menu">Profile</a></li>
    <li><a href="<?php echo base_url();?>login/privacy" class="active-menu">Change Password</a></li>
    <li><a href="<?php echo base_url();?>login/logout" class="active-menu">Logout</a></li>
  </ul>
</li>
<?php } ?>

<section class="block">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <div class="signup-form">
                  <?php if ($error) { ?>
                  <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      <?php echo $error; ?> </div>
                      <?php } ?>
                      <?php
                      if ($success) {?>
                      <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                          <?php echo $success;?> </div>
                            <?php } ?>
                    <span class="form-title">Enter Verification Code</span>
                    <span class="sub-title text-center">You should be enter 4-digits verification code</span>
                    <form id="varification" class="cntr" action="<?php echo site_url("login/activate"); ?>" enctype="multipart/form-data" method="post" class="form-horizontal" name="verification_user">

                      <input type="hidden" name="user_email" id="user_email" value="<?php echo $user_data;?>">
                        <div class="col-xs-3">
                            <div class="number-area">
                                <input type="text" class="form-control circle-varification first" onkeyup="movetoNext(this, 'second')" maxlength="1" name="code1" id="code1" style="border:none !important;">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="number-area">
                                <input type="text" class="form-control circle-varification second" onkeyup="movetoNext(this, 'third')" maxlength="1" name="code2" id="code2" style="border:none !important;">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="number-area">
                                <input type="text" class="form-control circle-varification third" onkeyup="movetoNext(this, 'forth')" maxlength="1" name="code3" id="code3" style="border:none !important;">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="number-area">
                                <input type="text" class="form-control circle-varification forth" maxlength="1" name="code4" id="code4" style="border:none !important;">
                            </div>
                        </div>
                        <button type="submit" id="send" class="btn btn-default full-width-btn rotate-btn" style="height: 100px !important;margin-top: 100px !important;"><span>NEXT</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

$(document).ready(function() {
  $(document).on('click', "#send", function () {
    var val1 = $('#code1').val();
    var val2 = $('#code2').val();
    var val3 = $('#code3').val();
    var val4 = $('#code4').val();
    if(val1 == '' || val2 == '' || val3 == '' || val4 == ''){
      swal({
            title: "",
            text: "Verification code must be of 4 digits",

        }, function () {

        })
        return false;
    }
  });
});
</script>
