<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
.cls_carousel_image{
  width:100%;
  height:130px;
  object-fit: cover;
}
.cls_item_img{
    width:100%;
    height:337px !important;
}
/* .nav_btn {
  margin-top: -26px;
} */
@media only screen and (max-width:480px){
  .cls_item_img{
      height:auto !important;
  }
  .nav_btn {
    margin-bottom: 150px;
    margin-top: -165px !important;
  }
  .customPrevBtn{
    margin-left: 0px;
  }
  .customNextBtn{
    margin-right: 0px;
  }
  .aero1 img {
    width: 9%;
  }
  .aero img {
    width: 9%;
  }
  .cls_cancellation p{
    text-align: center;
      padding-top: 0px;
  }
  .leftbox1{
    width: 100% !important;
    height: 215px;
  }
  .cls_other_star{
    width: 100%;
    margin-top: 14px;
    margin-left: 142px;
    float: none !important;
  }
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
<input type="hidden" name="shop_id" id="shop_id" value="<?=$servicelist->shop_id?>">
<div class="container">
	<div class="row p-detail-top">
    <div class="col-md-5">
      <div id="carousel" class="carousel slide img_gallery" data-ride="carousel">
          <div class="carousel-inner">
            <?php
              if(!empty($service_image_list)){
                foreach ($service_image_list as $key => $service_images) {
                  $img = $service_images->image;
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
                  }?>
                  <?php if($key == 0){
                    $active = 'active';
                  }else{ $active = '';}?>
                  <div class="item <?=$active?>">
                    <img src="<?=$main_image?>" class="cls_item_img" style="object-fit:cover;">
                  </div>
                <?php  }
              }else{?>
                <div class="item active">
                  <img src="<?=base_url()?>front/images/banner.jpg" class="cls_item_img" style="object-fit:cover;">
                </div>
          <?php }?>
        </div>
      </div>
      <div class="clearfix">
        <div class="owl-carousel owl-theme" style="margin-top: 10px;margin-bottom:10px;">
          <?php $i = 0;
          if(!empty($service_image_list)){
          foreach ($service_image_list as $key => $service_images) {
            $img = $service_images->image;
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
            }?>
            <div data-target="#carousel" data-slide-to="<?=$i?>" class="item"><img src="<?=$main_image?>" class="cls_carousel_image" style="cursor:pointer;"></div>
        <?php $i++; }
      }else{?>
        <div data-target="#carousel" data-slide-to="0" class="item"><img src="<?=base_url()?>front/images/banner.jpg" class="cls_carousel_image" style="cursor:pointer;"></div>
    <?php  }?>
      </div>
      </div>
      <div id="dvMap" style="width: 460px; height: 120px;border:1px solid #c2c2c2"></div>
		</div>
    <div class="col-md-7">
      <div class="product_details">
        <div class="like_dislike">
          <i class="fa <?php echo $heart; ?> heart_like_dislike" id="like_dislike" data-shopid="<?php echo $servicelist->shop_id; ?>" data-serviceid="<?php echo $servicelist->id; ?>" aria-hidden="true"> SHARE | FAVORITE</i>
          <?php
          $img = $servicelist->shop_image;
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
          }?>
          <a href="<?=$main_image?>" class="image-link">
            <img src="<?=$main_image?>" class="img-responsive img-circle" style="object-fit:cover;">
          </a>
        	<h2><?=ucfirst($servicelist->shop_name)?></h2><hr>
        </div>
        <div class="cmpny_details">
	        <p><?=ucfirst($servicelist->service_name)?> - with <?=ucfirst($servicelist->worker_name)?>  -  $<?=$servicelist->price?></p>
	        <div class="star-container">
            <?php for($i=0; $i < 5; $i++){?>
            <?php if($i < $roundEvg){?>
              <i class="fa fa-star fa-2x star-checked" id="star-<?php echo $i;?>"></i>
            <?php }else{ ?>
              <i class="fa fa-star fa-2x" id="star-<?php echo $i; ?>"></i>
            <?php }?>
            <?php }?>
	          <span>(<?=$review_list?>) <a href="<?php echo base_url('booking/review/'.$servicelist->shop_id)?>" style="color:#000;"> Show All</a></span><hr>
	       </div>

         <?php if($servicelist->user_id != @$_SESSION['uid']){ ?>
         <div class="bottom_btn_product">
           <?php if($userlist->u_category != 2){?>
           <div class="button_link">
             <a href="<?php echo base_url('chat?id='.$servicelist->user_id); ?>">MESSAGE US</a>
           </div>
         <?php }?>
             <a class="btn-link-a" href="<?=site_url()?>appointment/appointment_step1/<?=$servicelist->encrypt_shop_id?>/<?=$servicelist->encrypt_id?>"><div class="button_link1">BOOK NOW</div></a>
         </div>
         <?php }?>
	       <div class="bottom_social_link">
	         <div class="social-area">
            <a href="https://twitter.com/GgGroom" target="_blank"><img src="<?php echo base_url('front/images2/twitter.png');?>"></a>
            <a href="https://www.facebook.com/gggroom/" target="_blank"><img src="<?php echo base_url('front/images2/facebook-icon.png');?>"></a>
            <a href="https://www.instagram.com/gggroomapp/" target="_blank"><img src="<?php echo base_url('front/images2/insta-icon.png');?>"></a>
          </div>
	      </div>
	      <p style="font-weight: normal; text-align: justify;"><?=$servicelist->shop_description?></p>
	    </div>
    </div>
  </div>
 </div>
</div>

<!-- other services section -->
<?php if(!empty($other_service_list)){?>
<section>
	<div class="other_services">
		<div class="container">
			<h2 style="text-align: center;">OTHER SERVICES BY - <?=ucfirst($servicelist->shop_name)?> </h2>
			<br>
      <div class="owl-carousel owl-theme service_carousel" >
        <?php
            foreach ($other_service_list as $key => $other_service) {
              $service_img = $other_service->image;
              $temp_file = base_url()."front/images/banner.jpg";
              $main_file = "assets/uploads/service_image/".$service_img;
              $filename = FCPATH.$main_file;
              if (file_exists($filename)) {
                if($service_img != ''){
                    $main_image =  base_url().$main_file;
                }else{
                    $main_image =  $temp_file;
                }
              }else{
                $main_image =  $temp_file;
              }

              if(!empty($other_service->und_sub_category->cat_name)){
                  $category = $other_service->und_sub_category->cat_name.' - ' .$other_service->sub_category->cat_name;
                  $main_cat = $other_service->service_name;
              }else if(!empty($other_service->sub_category->cat_name)){
                  $category = $other_service->sub_category->cat_name;
                  $main_cat = $other_service->service_name;
              }else{
                  $category = $other_service->service_name;
                  $main_cat = '';
              }
              ?>
        <div class="col-md-12 leftbox1">
          <div class="col-md-5">
            <a href="<?=site_url()?>detail/shop_detail/<?=$other_service->encrypt_id?>">
              <img src="<?=$main_image?>" width="200px" height="150px">
            </a>
          </div>
          <div class="col-md-7">
            <div class="cls_other_star" style="float: right;">
              <?php for($i=0; $i < 5; $i++){?>
              <?php if($i < $other_service->ratingRound){?>
                <span class="fa fa-star checked" id="star-<?=$i?>"></span>
              <?php }else{ ?>
                <span class="fa fa-star" id="star-<?=$i?>"></span>
              <?php }?>
              <?php }?>
            </div>
            <h3 style="color:#049597; margin-top: 25px;"><?=$category?></h3>
            <p style="padding-top: 3px"><?=$main_cat?> <br><?=$other_service->shop_name?></p>
            <h2 style="margin-bottom: 0px; margin-top: 0px;color:#049597">$<?=$other_service->price?></h2>
            <a href="<?=site_url()?>appointment/appointment_step1/<?=$other_service->encrypt_shop_id?>/<?=$other_service->encrypt_id?>" style="color:#fff;"><div class="buttons">Book Now</div></a>
          </div>
        </div>
      <?php }?>
      </div>
      <div class="nav_btn">
        <div class="customPrevBtn service_carousel_customPrevBtn">
          <span class="aero1"><img src="<?php echo base_url('front/images2/left.png');?>" alt="Button prev"></span>
        </div>
        <div class="customNextBtn service_carousel_customNextBtn">
          <span class="aero"><img src="<?php echo base_url('front/images2/right.png');?>" alt="Button next"></span>
        </div>
      </div>
		</div>
  </div>
</section>
<?php }?>

<!-- Business hours -->
<div class="open hours">
	<div class="container">
		<div class="col-md-6 col-md-offset-3">
			<h3 style="text-align: center; padding: 20px 0">BUSINESS HOURS</h3>
			<div class="">
			  <table class="table table-striped">
          <?php foreach ($shop_business_hours_list as $key => $hours_list) {
            if($key == 0){ $day = 'Monday'; }
            if($key == 1){ $day = 'Tuesday'; }
            if($key == 2){ $day = 'Wednesday'; }
            if($key == 3){ $day = 'Thursday'; }
            if($key == 4){ $day = 'Friday'; }
            if($key == 5){ $day = 'Saturday'; }
            if($key == 6){ $day = 'Sunday'; }
            $time1 = $hours_list->from_time;
            $time2 = $hours_list->to_time;
            $from_time = date("g:i A", strtotime($time1));
            $to_time = date("g:i A", strtotime($time2));?>
          <tr>
            <td><?=$day?></td>
            <?php if($hours_list == ''){?><td>Closed</td><td></td><?php }else{
                ?>
                <td><?=$from_time?></td><td><?=$to_time?></td>
            <?php  }?>
          </tr>
      <?php }?>
			</table>
		</div>
	</div>
</div>
</div>

<!-- Cancellation policy section -->
<?php if($servicelist->shop_cancel_policy == 1){
  $cancel_policy = '<b>Strict</b> - No cancellation';
}else if($servicelist->shop_cancel_policy == 2){
  $cancel_policy = '<b>Moderate</b> - Cancellation before 48 hours';
}else if($servicelist->shop_cancel_policy == 3){
  $cancel_policy = '<b>Flexible</b> - Anytime cancellation';
}?>
<div class="step_main cls_cancellation">
	<div class="container">
		<h2 style="text-align: center;">CANCELLATION POLICY</h2><br>
		<h4 style="text-align: center;color: rgb(255, 109, 0);"><?=$cancel_policy?></h4>
		<section id="Steps" class="steps-section">
	    <div class="steps-timeline">
	      <div class="steps-one <?php if($servicelist->shop_cancel_policy == 1){ echo 'active';}?>">
	        <div class="steps-img">1</div>
	        <h3 class="steps-name1">Strict</h3>
	        <p class="steps-description1">No cancellation</p>
	      </div>
	      <div class="steps-two <?php if($servicelist->shop_cancel_policy == 2){ echo 'active';}?>">
	        <div class="steps-img">2</div>
	        <h3 class="steps-name">Moderate</h3>
	        <p class="steps-description">Cancellation before 48 hours </p>
	      </div>
	      <div class="steps-three <?php if($servicelist->shop_cancel_policy == 3){ echo 'active';}?>">
	        <div class="steps-img">3</div>
	        <h3 class="steps-name2">Flexible</h3>
	        <p class="steps-description2">Anytime cancellation </p>
	      </div>
	     </div>
	   </section>
	</div>
</div>

<script src="<?=base_url()?>front/js/owl.carousel.min.js"></script>
<script type="text/javascript">
var service_carousel = $('.service_carousel');
// service_carousel.owlCarousel();
service_carousel.owlCarousel({
margin: 0,
nav: false,
loop: false,
items: 1,
rewind: true,
responsive: { 0: { items: 1 }, 850: { items: 2 }}
})

$('.service_carousel_customNextBtn').click(function() { service_carousel.trigger('next.owl.carousel'); })
$('.service_carousel_customPrevBtn').click(function() { service_carousel.trigger('prev.owl.carousel', [300]); })


var related_service_carousel = $('.related_service_carousel');
// service_carousel.owlCarousel();
related_service_carousel.owlCarousel({
margin: 0,
nav: false,
loop: true,
items: 3,
rewind: true,
responsive: { 0: { items: 1 }, 850: { items: 2 }, 1240: { items: 3 } }
})

$('.related_service_carousel_customNextBtn').click(function() { related_service_carousel.trigger('next.owl.carousel'); })
$('.related_service_carousel_customPrevBtn').click(function() { related_service_carousel.trigger('prev.owl.carousel', [300]); })

$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    items: 3,
});

$(document).ready(function() {
$('.image-link').viewbox();
  // $('.image-link').viewbox();
  // $('.image-link').viewbox({
  //   setTitle: true,
  //   margin: 20,
  //   resizeDuration: 300,
  //   openDuration: 200,
  //   closeDuration: 200,
  //   closeButton: true,
  //   navButtons: true,
  //   closeOnSideClick: true,
  //   nextOnContentClick: true
  // });
});


</script>
