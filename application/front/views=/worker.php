<?php $this->load->view('templates/_include/header_view1'); ?>

<section class="block">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 cls_row_shop">
              <a href="<?php echo base_url();?>profile" class="btn btn-default cls_btn_back"><span>Go back</span></a>
                <div class="edit-form">
                  <div class="image_change2">
                    <a href="<?php echo site_url();?>worker/add_worker">
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
                        foreach ($workerlist as $worker) {
                          $img = $worker->image;
                          $temp_file = base_url()."front/images/banner.jpg";
                          $main_file = "assets/uploads/worker_image/".$img;
                          $filename = FCPATH.$main_file;
                          if (file_exists($filename)) {
                            if($img != ''){
                                $main_image =  base_url().$main_file;
                            }else{
                                $main_image =  $temp_file;
                            }
                          }else{
                            $main_image =  $temp_file;
                          }?>
                          <div class="col-md-4 col-xs-8 cls-image-block">
                              <div class="form-group">
                                <a href="<?php echo site_url();?>worker/edit_worker/<?=$worker->encrypt_id?>">
                                  <img src="<?=$main_image?>" style="height:200px;width:100%; border-radius:10px;object-fit: cover;">
                                <p class="imagechangetxt"><?php echo $worker->name;?></p>
                                </a>
                              </div>
                          </div>
                      <?php  }?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>
