<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
.top-right {
  position: absolute;
  top: 8px;
  right: 16px;
  padding: 5px 10px 5px 10px;
  background: #059797;
  color: white;
  margin-right: 10px;
  cursor: pointer;
}
  @media only screen and (max-width:480px){
    .cls_name_h4{
      font-size: 21px !important;
    }
    .cls_h3_shop_name{
      text-align: center;
    }
  }
</style>
    <div class="main_cls">
    <?php //if(!empty($search_result)){ ?>
      <div class="related_services product_round">
         <input type="hidden" name="search_result" id="search_result" value="<?=$search_result?>">

          <div class="container">
            <div class="col-md-12 col-xs-12">
               <span class="form-title" style="color:#05524f;">Shops</span>
               <input type="hidden" name="count_shops" id="count_shops" value="4">
            </div>
            <div class="col-md-12 col-xs-12">
               <h4 class="form-title cls_name_h4" style="padding-top:0px;color:#05524f;">Your search returned <?=$count_shop?> results!</h4>
            </div>
             <div class="product_round_sub">
               <div class="shop_filter_data">
               <?php
               if(!empty($shop_list)){
                 foreach ($shop_list as $key => $shop) {
                   $img = $shop->image;
                   $temp_file = base_url()."front/images/banner.jpg";
                   $main_file = "assets/uploads/shop/".$img;
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
                       $main_url = '#';
                   }else{
                       $main_url = site_url().'shop/services/'.$shop->shop_id;
                   }?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                   <div class="related_service_item_main">
                      <div class="related_service_item">
                         <div class="home_img">
                           <a href="<?=$main_url?>">
                             <img src="<?=$main_image?>" class="img-responsive" style="height: 170px;width:auto;display: inline; border-radius:10px;">
                           </a>
                           <?php
                             if($shop->varification == 1){?>
                             <div class="top-right unclaime">Unclaimed</div>
                           <?php }?>
                          </div>
                         <h3 class="cls_h3_shop_name"><?=$shop->shop_name?></h3>
                         <!-- <span style="font-size: 15px;"><?=$shop->shop_email?></span> -->
                      </div>
                   </div>
                </div>
              <?php }?>
            <?php }else{?>
              <!-- <p style="margin-left: 15px;">(No results found!)</p> -->
            <?php }?>
             </div>
            </div>
          </div>
          <?php
          if(!empty($shop_list)){
            if($count_shop >= 4){?>
          <div class="container cls_shop_view_more">
             <div class="col-md-12 col-xs-12">
                <span class="form-title">
                  <a href="javasript:void(0)" class="color_green" id="all_shop_view_more">View More <i class="fa fa-chevron-right" aria-hidden="true"></i>
                  </a>
                </span>
             </div>
          </div>
        <?php }}?>
      </div>

       <div class="related_services product_round">
          <div class="container">
            <div class="col-md-12 col-xs-12">
               <span class="form-title" style="color:#05524f;">Services</span>
               <input type="hidden" name="count_services" id="count_services" value="<?=$check_worker_service?>">
            </div>
            <div class="col-md-12 col-xs-12">
               <h4 class="form-title cls_name_h4" style="padding-top:0px;color:#05524f;">Your search returned <?=$count_service?> results!</h4>
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
                           <a href="<?=site_url()?>detail/shop_detail/<?=$service->encrypt_id?>">
                             <img src="<?=$main_image?>" class="img-responsive" style="height: 170px;width:auto;display: inline; border-radius:10px;">
                           </a>
                          </div>
                         <h3><?=$category?></h3>
                         <a href="<?=site_url()?>detail/shop_detail/<?=$service->encrypt_id?>">
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
              <!-- <p style="margin-left: 15px;">(No results found!)</p> -->
            <?php }?>
            </div>
          </div>
          </div>
          <?php
          if(!empty($servicelist)){
            if($count_service >= 4){?>
          <div class="container cls_service_view_more">
             <div class="col-md-12 col-xs-12">
                <span class="form-title">
                  <a href="javasript:void(0)" class="color_green" id="all_services_view_more">View More <i class="fa fa-chevron-right" aria-hidden="true"></i>
                  </a>
                </span>
             </div>
          </div>
        <?php }}?>
       </div>
    <?php //}else{ ?>
      <!-- <div class="home_filter">
       <div class="container">
          <div class="product_round_sub">
              <span class="form-title" style="color:#05524f;">No results found!</span>
          </div>
       </div>
      </div> -->
    <?php //} ?>
    </div>
