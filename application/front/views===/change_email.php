<?php $this->load->view('templates/_include/header_view1');?>
<style media="screen">
  #u_email{
    color:#000 !important;
    border: solid 2px #008080 !important;
    width: 66%;
  }
  .cls_email_div{
      margin-left: 188px !important;
    }
  @media only screen and (max-width:480px){
    #u_email{
      width: 100%;
    }
    .cls_email_div{
        margin-left: 0px;
      }
  }
  .rhombus-button{
    float: none;
    height: 100px !important;
    margin-top: 100px !important;
    width: 13% !important;
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
                    <span class="form-title" style="margin-top:20px;">Change Email</span>
                    <form id="change_email_form" action="<?php echo site_url("profile/update_email"); ?>" enctype="multipart/form-data" method="post" class="form-horizontal change_pwd_form" name="change_email_form" data-toggle="validator">
                      <div class="form-group cls_email_div">
                           <label> <span class="label-text">Email <span class="cls_star">*</span></span> </label>
                           <input type="email" class="form-control " id="u_email" name="u_email" value="<?=$user_email?>">
                      </div>
                      <div class="form-group" style="text-align:center;">
                        <a href="<?php echo base_url();?>setting" class="btn btn-default full-width-btn rotate-btn rhombus-button" style="float:none;margin-right: 50px !important;"><span style="margin-top: 30px;">BACK</span></a>
                        <button type="submit"  class="btn btn-default full-width-btn rotate-btn rhombus-button" style="float:none;"><span>UPDATE</span></button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
