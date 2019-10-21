<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
  @media only screen and (max-width:480px){
    .cls_name_h4{
      font-size: 21px !important;
    }
  }
</style>
    <div class="main_cls">
       <div class="related_services product_round">
         <input type="hidden" name="shop_id" id="shop_id" value="<?=$main_shop_id?>">
          <input type="hidden" name="shop_id_encrypt" id="shop_id_encrypt" value="<?=$shop_id_encrypt?>">

         
          <div class="container">
            <div class="col-md-12 col-xs-12">
               <span class="form-title" style="color:#05524f;">Services</span>
               <input type="hidden" name="count_services" id="count_services" value="<?=$check_worker_service?>">
            </div>
            <div class="col-md-12 col-xs-12">
               <h4 class="form-title cls_name_h4" style="padding-top:0px;color:#05524f;">Your shop returned <?=$count_service?> services!</h4>
            </div>
            <div class="product_round_sub">
            <div class="service_filter_data">
            <?php
            if(!empty($servicelist)){
              foreach ($servicelist as $key => $service) {
                $img = $service->image;
                $temp_file = base_url()."front/images/banner.jpg";
                $main_file = "assets/uploads/service_image/".$img;
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

                if(!empty($service->und_sub_category->cat_name)){
                    $category = $service->und_sub_category->cat_name.' - ' .$service->sub_category->cat_name;
                }else{
                  $category = $service->sub_category->cat_name;
                }
                $heart = ($service->fav == "1")  ? 'fa-heart' : 'fa-heart-o';?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                   <div class="related_service_item_main">
                      <div class="related_service_item">
                         <div class="like_dislike">
                            <i class="fa <?php echo $heart; ?> heart_like_dislike" data-shopid="<?php echo $service->shop_id; ?>" data-serviceid="<?php echo $service->id; ?>" data-userid="<?php echo $UserId; ?>" aria-hidden="true"></i>
                         </div>
                         <div class="home_img">
                           <a href="<?=site_url()?>detail/shop_detail/<?=$shop_id_encrypt?>/<?=$shop_id?>/<?=$service->encrypt_id?>">
                             <img src="<?=$main_image?>" class="img-responsive" style="height: 170px;width:auto;display: inline; border-radius:10px;">
                           </a>
                          </div>
                         <h3><?=$category?></h3>
                         <a href="<?=site_url()?>detail/shop_detail/<?=$shop_id_encrypt?>/<?=$shop_id?>/<?=$service->encrypt_id?>">
                           <p><?=$service->service_name?>  -  $<?=$service->price?></p>
                         </a>
                         <span><?=$service->shop_name?></span>
                         <div class="star-container">
                            <?php for ($i=0; $i < 5; $i++) {   ?>
                            <?php if($i < $service->ratingRound){ ?>
                              <i class="fa fa-star fa-2x star-checked" id="star-<?php echo $i; ?>"></i>
                            <?php }else{ ?>
                              <i class="fa fa-star fa-2x" id="star-<?php echo $i; ?>"></i>
                            <?php } ?>
                            <?php } ?>
                            <span>(<?=$service->review_list?>)</span>
                         </div>
                      </div>
                   </div>
                </div>
              <?php }?>
            <?php }else{?>
              <!-- <p>(No services available)</p> -->
            <?php }?>
            </div>
          </div>
          </div>
          <?php
          if(!empty($servicelist)){?>
          <div class="container">
             <div class="col-md-12 col-xs-12">
                <span class="form-title">
                  <a href="javasript:void(0)" class="color_green" id="view_more_shop_details">View More <i class="fa fa-chevron-right" aria-hidden="true"></i>
                  </a>
                </span>
             </div>
          </div>
        <?php }?>
       </div>
    </div>
