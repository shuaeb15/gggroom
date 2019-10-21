<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
.edit-form{
  border: 20px solid #c2c2c2;
}
.image_change{
  position: absolute;
    top: 11px;
    left: 536px;
}
.image_change1{
  margin-top: 115px;
    margin-left: 417px;
}
.cls_btn_back{
  margin-left: -185px;
  margin-right: 30px !important;
  margin-top: 82px !important;
  float: right;
  font-size: 20px;
  color: #fff;
  background: #059797;
  border: none;
  height: auto;
  padding: 9px 30px;
}
.cls_btn_back:hover{
  color: #fff;
  background: #059797;
}

@media only screen and (max-width:480px){
  .image_change {
    left: 140px;
}
.image_change1{
    margin-left:71px;
}
  .cls_btn_back{
    margin-top:100px !important;
    width: -1%;
    margin-left: -185px;
    margin-right: 5px;
    font-size: 16px;
    padding: 9px 17px;
  }
  .cls-image-block{
        width: 100% !important;
  }
}

</style>
<section class="block">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12">
        <a href="<?php echo base_url();?>profile" class="btn btn-default cls_btn_back"><span>Go back</span></a>
        <div class="edit-form">
          <form action="">
            <div class="image_change">
              <a href="<?php echo site_url();?>service/add_service">
                <img src="<?=base_url()?>front/images/plus.png" alt="" title="" class="img-responsive img-circle upload_img" style="width: 90px;height:90px;" />
              </a>
            </div>
            <div class="" style="margin-top: 45px;">
              <?php if ($this->session->flashdata('error_message')) { ?>
                      <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $this->session->flashdata('error_message'); ?> </div>
              <?php } ?>
              <?php if ($this->session->flashdata('success_message1')) { ?>
                      <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                      <?php echo $this->session->flashdata('success_message1');?>
                     </div>
              <?php } ?>
            </div>
            <div class="image_change1">
              <img src="<?=base_url()?>front/images/services.png" alt="" title="" class="img-responsive upload_img" style="width:auto;"/>
            </div>
            <span class=" sub-title text-center" style="margin: 15px 0 15px !important;"><b>No service found </b></span>
          <div class="col-xs-2 col-sm-2"> </div>
          <div class="col-xs-8 col-sm-8">
            <span class="sub-title text-center" style="margin: 15px 0 55px !important;"> You haven't created any service yet. Press plus icon to add the new service.</span>
          </div>
          <div class="col-xs-2 col-sm-2"> </div>
        </form>
      </div>
    </div>
  </div>
</div>
</section>
