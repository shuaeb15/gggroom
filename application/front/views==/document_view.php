<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
.image_change{
  position: absolute;
    top: 11px;
    left: 536px;
}
.cls_btn_back{
  margin-left: -185px;
  margin-right: 35px !important;
  margin-top: 90px !important;
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
.image_delete{
  top: 12px;
    right: 8px;
    position: absolute;
    height: 22px;
    width: 22px;
    opacity: 1;
}
@media only screen and (max-width:480px){
  .image_change {
    left: 140px;
}
  .cls_btn_back{
    width: -1%;
    margin-left: -185px;
    margin-right: 5px;
    font-size: 16px;
    padding: 9px 17px;
    margin-top: 92px !important;
  }
  .cls-image-block{
        width: 100% !important;
  }
  .edit-form{
    border: 15px solid #c2c2c2 !important;
  }
  .cls_doc_list{
    padding: 10px 10px 10px 10px;
  }
}
</style>

<section class="block">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <a href="<?php echo base_url();?>profile" class="btn btn-default cls_btn_back"><span>Go back</span></a>
                <div class="edit-form" style="border: 30px solid #c2c2c2;">
                  <div class="image_change">
                    <a href="<?php echo site_url();?>document/add_document">
                      <img src="<?=base_url()?>front/images/plus.png" alt="" title="" class="img-responsive img-circle upload_img" style="width: 90px;height:90px;" />
                    </a>
                  </div>
                  <div class="cls_doc_list" style="margin-top: 66px;">
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
                      <?php
                      $count=0;
                      foreach ($document_list as $key => $doc) {
                        $count++;
                          $file = $doc->name;
                          $doc_name = $doc->caption;
                          $main_file = "assets/uploads/document/".$file;
                          $main_image =  base_url().$main_file;
                          $dot = '.';?>
                          <div class="col-md-10 cls_document_<?=$doc->id?>" style="border-bottom: solid 1px #059797;padding-bottom: 5px;padding-right: 60px;padding-left: 0px;width:100%;margin-bottom:10px;">
                            <a href="<?=$main_image?>" download style="font-size:25px;color:#059797;"><?=$count?><?=$dot?> <?=$doc_name?><br>
                            </a>
                            <img src="<?php echo base_url()?>front/images/close.png" class="close image_delete" data-image-id="<?=$doc->id?>">
                          </div>
                      <?php  }?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function(){
$(document).on('click', ".image_delete", function () {
  var img_id = $(this).attr('data-image-id');
  swal({
    title: "Are you sure?",
    text: "You want to delete this document",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "Yes, delete",
    cancelButtonText: "No, cancel",
    closeOnConfirm: true,
    closeOnCancel: true
  },
  function(isConfirm) {
    if (isConfirm) {
      $.ajax({
        url: "<?php echo base_url(); ?>document/delete_document",
        type: 'post',
        data: {img_id:img_id},
        success: function (data) {
          $( ".cls_document_"+img_id ).remove();
        },
      });
    }
  });
});
});
</script>
