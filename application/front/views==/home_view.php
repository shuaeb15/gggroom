<?php
$this->load->view('templates/_include/header_view1');
$this->load->view('templates/_include/search_filter_view');
?>
<style media="screen">
span{
  color: #000;
}
p{
  color: #000;
}
.cls_service_header{
  color: #049597 !important;
}
.cls_service_price{
  color: #049597 !important;
}
@media only screen and (max-width:480px){
  .col-md-12{
    position: initial !important;
  }
  .col-md-6{
    width:100% !important;
    position: initial !important;
  }
}
</style>
<section>
 <div class="container">
	<div class="home-display">
    <?php if (!$this->session->userdata('uid')) {?>
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
    <?php }?>
		<div class="htext">
			<h2 style="color: #000;">NEAR YOUR HOME</h2>
      <input type="hidden" name="total_all_services" id="total_all_services" value="0">
      <input type="hidden" name="all_services" id="all_services" value="4">
			<div class="proinbox_main">
        <span class="proinbox">SHOW MAP</span>
        <div class="form-group switch_title" style="">
          <label class="switch">
            <input type="checkbox" checked="" id="showmap">
            <span class="slider round"></span>
          </label>
        </div>
			</div>
		</div>
	</div>
  <div class="col-md-12">
    <div class="col-md-12 col-sm-12 col-xs-12 pull-right" id="map_show_hide" style="margin-bottom: 50px;">
      <div class="related_service_item_main">
        <div class="related_service_item">
          <div id="dvMap" style="width: 100%; height: 400px;"></div>
        </div>
      </div>
    </div>
    <div id="map" style="width: 100%; height: 580px;display:none;"></div>
    <br>
    <div class="col-md-12 cls_services_div">
      <div class="homeFilter">
      </div>
    </div>
    <div class="near_home_services" style="text-align: center;font-size: 22px;"></div>
    </div>
    <div class="col-md-12">
      <div id="load_data_message" style="text-align:center;"></div>
    </div>
  </div>
  </div>
 </div>
</section>
<?php if(!empty($top_rated_service_list)){?>
<section class="related_services">
  <div class="container">
	  <div class="home-display">
		 <div class="htext">
			 <h2 style="color: #000;">TOP RATED</h2>
		 </div>
	  </div>
    </div>
    <div class="container">
	  <div class=" toprated owl-carousel owl-theme related_service_carousel">
      <?php foreach ($top_rated_service_list as $key => $rated_service) {
        $img = $rated_service->image;
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

        if(!empty($rated_service->und_sub_category->cat_name)){
            $category = $rated_service->und_sub_category->cat_name.' - ' .$rated_service->sub_category->cat_name;
            $parent_cat = $rated_service->service_name;
        }else if(!empty($rated_service->sub_category->cat_name)){
            $category = $rated_service->sub_category->cat_name;
            $parent_cat = $rated_service->service_name;
        }else{
            $category = $rated_service->service_name;
            $parent_cat = '';
        }
        $heart = ($rated_service->fav == "1")  ? 'fa-heart' : 'fa-heart-o';
      ?>
      <div class="item">
			 <div class="col-md-12">
         <a href="<?=base_url()?>detail/shop_detail/<?=$rated_service->encrypt_id?>">
				 <img src="<?=$main_image?>"></a>
			 </div>
			 <div class="col-md-12 toprated_body">
					<h4 style="color: #000;"><?=$category?></h4>
					<p style="font-weight: bold; padding-top: 0px;color: #000;"><?=$parent_cat?> $<?=$rated_service->price?></p>
					<p style="font-weight: bold; padding-top: 0px;line-height: 5px;color: #000;"><?=$rated_service->shop_name?></p>
					<div style="float: left;">
            <?php for ($i=0; $i < 5; $i++) {   ?>
            <?php if($i < $rated_service->ratingRound){ ?>
              <span class="fa fa-star checked" id="star-<?php echo $i; ?>"></span>
            <?php }else{ ?>
              <span class="fa fa-star" id="star-<?php echo $i; ?>"></span>
            <?php } ?>
            <?php } ?>
					</div>
				</div>
		</div>
  <?php }?>
	</div>
  <div class="nav_btn">
     <div class="customPrevBtn related_service_carousel_customPrevBtn">
        <img src="<?=base_url()?>front/images/left_arrow.png" alt="Button prev">
     </div>
     <div class="customNextBtn related_service_carousel_customNextBtn">
        <img src="<?=base_url()?>front/images/right_arrow.png" alt="Button next">
     </div>
  </div>
</div>
</section>
<?php }?>

<script type="text/javascript">
<?php
if(count($top_rated_service_list) <= 3){?>
  $('.nav_btn').hide();
<?php }else{?>
  $('.nav_btn').show();
<?php }?>

(function () {
var selector = '[data-rangeSlider]',
  elements = document.querySelectorAll(selector);
 var changeValBtn = document.querySelector('#timerange');

function valueOutput(element) {
  var value = element.value,
    output = element.parentNode.getElementsByTagName('output')[0];
    output.innerHTML = value;
}

for (var i = elements.length - 1; i >= 0; i--) {
  valueOutput(elements[i]);
}

Array.prototype.slice.call(document.querySelectorAll('input[type="range"]')).forEach(function (el) {
  el.addEventListener('input', function (e) {
    valueOutput(e.target);
  }, false);
});
// Basic rangeSlider initialization
rangeSlider.create(elements, {
  // Callback function
  onInit: function () {
  },

});
})();
</script>
