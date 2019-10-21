<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
  .unclaime{
    text-align: center;
  }
</style>
<section class="block">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 cls_row_shop">
                <a href="<?php echo base_url();?>profile" class=" btn-default cls_btn_back"><span>Go back</span></a>
                <div class="edit-form">
                  <div class="image_change2">
                    <a href="<?php echo site_url();?>shop/add_shop">
                      <img src="<?=base_url()?>front/images/plus.png" alt="" title="" class="img-responsive img-circle upload_img" style="width: 90px;height:90px;" />
                    </a>
                  </div>
                  <div class="" style="margin-top: 66px;">
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
                      // echo "<pre>"; print_r($shoplist);exit;
                        $i=1;
                        foreach ($shoplist as $shop) {
                          $img = $shop->image;
                          $temp_file = base_url()."front/images/banner.jpg";
                          $main_file = "assets/uploads/shop_image/".$img;
                          $filename = FCPATH.$main_file;
                          if (file_exists($filename)) {
                            if($img != ''){
                                $main_image =  base_url().$main_file;
                            }else{
                                $main_image =  $temp_file;
                            }
                          }else{
                            $main_image =  $temp_file;
                          }

                          if($shop->varification == 1){
                              $unclaim = '<span style="color:#059797;"> - Unclaimed</span>';
                          }else{
                              $unclaim = '';
                          }?>
                          <div class="col-md-4 col-xs-8 cls-image-block" <?=($i%3 == 1) ? 'style="clear:both;"' : ''?> >
                              <div class="form-group">
                                <a href="<?php echo site_url();?>shop/edit_shop/<?=$shop->encrypt_id?>">
                                  <img src="<?=$main_image?>" style="height:200px;width: 100%; border-radius:10px;object-fit: cover;">
                                <p class="imagechangetxt"><?php echo $shop->shop_name.$unclaim;?></p>
                                </a>
                                <?php
                                  if($shop->varification == 1){?>
                                  <div class="top-right unclaime" data-shop-id="<?=$shop->id?>">Claim this shop</div>
                                <?php }?>
                              </div>
                          </div>
                      <?php $i++; }?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Claim shop</h4>
      </div>
      <span class="sub-title text-center" style="font-size: 19px;"> Enter your email address and will send you a code for verification</span>
       <form action="<?php echo base_url();?>shop/confirm_varification" enctype="multipart/form-data" method="post" class="form-horizontal" id="shop_varification" name="shop_varification" data-toggle="validator">
         <div class="modal-body">
            <input type="hidden" name="shop_id" id="shop_id" value="">
             <div class="">
                 <label for="fname">Email <span class="cls_star">*</span></label>
                 <input type="text" class="form-control " id="recovery_email" name="recovery_email" style="border: solid 2px #008080 !important;color:#000 !important;">
             </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default save_shop_bt cls_save_btn" style="width: 113px !important;">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$('.unclaime').click(function(){
  var shop_id = $(this).attr('data-shop-id');
  $('#shop_id').val(shop_id);
    $('#myModal').modal('show');
});

</script>
