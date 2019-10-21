<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
label.css-label-check{
  margin-bottom: 0px !important;
}
@media only screen and (max-width:480px){
  .edit-form{
    padding: 0px !important;
  }
}
</style>
<section class="block bg_white">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12">
        <div class="edit-form shop-form">
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

          <form enctype="multipart/form-data" method="post"  id="add_offer_view" name="add_offer_view" data-toggle="validator" action="<?php echo site_url("offers/insert_offer/"); ?>">
            <div class="col-xs-12 col-sm-12 col-md-12 cls_top" style="text-align: center;">
              <span class="form-title">PROMOTIONS AND OFFERS</span>
              <span class="form-title" style="font-size:14px;"><a href="<?=DOMAIN_URL?>">Home</a> > <a href="<?=DOMAIN_URL?>profile">Profile</a></span>
              <!-- <span class="form-title" style="float:none;font-size: 25px;margin: 0 auto 30px auto;">Promotions and offers</span> -->
            </div>
            <div class="col-md-12 col-xs-12 cls_md_12" style="margin-bottom:30px;">
              <div class="col-md-9 col-xs-12">
                 <div class="item form-group">
                   <label class="control-label1 col-xs-12" for="product">Offer code</label><br>
                      <input id="offer_code" class="form-control col-md-7 col-xs-12" name="offer_code" type="text">
                  </div>
                </div>
                <div class="col-md-9 col-xs-12">
                   <div class="item form-group">
                     <label class="control-label1 col-xs-12" for="product"></label><br>
                     <label class="control-label1 col-xs-12" for="product">Discount</label><br>
                      <select class="form-control col-md-7 col-xs-12" name="discount_type" id="discount_type">
                        <option value="">select</option>
                        <option value="1">Percentage</option>
                        <option value="2">Fixed amount</option>
                      </select>
                      <label class="control-label1 col-xs-12 cls_price_lbl" for="product" style="margin-top:20px; line-height:1;">Price</label><br>
                      <input id="price" class="form-control col-md-7 col-xs-12" name="price" type="number" placeholder="Enter value">
                    </div>
                </div>
                <div class="col-md-9 col-xs-12">
                  <label class="control-label1 col-xs-12" for="product"></label><br>
                  <div class="item form-group cls_radio_btn">
                     <!-- <div class="col-xs-12 cls-chk" style="font-size: 19px !important;"> -->
                       <input type="radio" name="offer_radio_type" id="radio7" class="css-checkbox offer_radio_type" checked value="1"/>
                       <label for="radio7" class="css-label css-label-check radGroup1 radGroup2">
                         <span>General Offer</span>
                       </label>
                       <input type="radio" name="offer_radio_type" id="radio8" class="css-checkbox offer_radio_type" value="2"/>
                       <label for="radio8" class="css-label css-label-check radGroup1 radGroup2">
                         <span>Service Offer</span>
                       </label>
                     <!-- </div> -->
                   </div>
                </div>
                <div class="col-md-9 col-xs-12 cls_service">
                  <div class="item form-group">
                    <label class="control-label1 col-xs-12" for="product"></label><br>
                    <label class="control-label1 col-xs-12" for="product">Services</label><br>
                    <div class="col-xs-12">
                      <input type="hidden" class="form-control col-md-7 col-xs-12" name="service_id" id="service_id" value="">
                      <!-- <input type="text" class="form-control col-md-7 col-xs-12" name="service_name" id="service_name" value=""> -->
                      <select class="form-control col-md-7 col-xs-12" name="service_name" id="service_name">
                        <option value="">Select</option>
                        <?php foreach ($services_list as $key => $value): ?>
                          <option value="<?=$value->id?>"><?=$value->service_name?> - <?=$value->shop_name?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line margin_bottom_30">
            </div>
            <div class="col-md-12 center_btn_main">
              <div class="center_btn_sub">
                <div class="center_btn_subitem">
                  <button type="button" class="dlt_shop_btn" id="btn-submit">Cancel</button>
                </div>
                <div class="center_btn_subitem">
                  <button type="submit" class="save_shop_btn btn_save_services">Save</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  var site_url = $("#site_url").val();

</script>
<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="Stylesheet"></link>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
  $('.dlt_shop_btn').click(function(){
      window.location.href = '<?php echo base_url(); ?>profile';
  });

  $('#service_name').editableSelect().on('select.editable-select', function (e, li) {
        $('#last-selected').html(
          $('#service_id').val(li.val())
        );
    });
  $(".offer_radio_type").click(function(e) {
      var offer_type1 = $("input[name='offer_radio_type']:checked").val();
      if(offer_type1 == 1){
          $('.cls_service').hide();
     }else{
        $('.cls_service').show();
     }
  });

  var offer_type = $("input[name='offer_radio_type']:checked").val();
  if(offer_type == 1){
    $('.cls_service').hide();
  }else{
    $('.cls_service').show();
  }

  $(document).on('click', ".btn_save_services", function () {
    var offer_type = $("input[name='offer_radio_type']:checked").val();
    if(offer_type == 2){

      var services = $("#service_name").val();
      if(services == ''){
        swal({
              title: "",
              text: "Please enter service",

          }, function () {
            $('html, body').animate({
                    scrollTop: $('.cls_service').offset().top
                }, 'slow');
          })
          return false;
      }
    }
  });

  $("#discount_type").change(function(e) {
    var discount = $(this).val();
    if(discount == 2){
        $('.cls_price_lbl').html('Price ($)');
    }else{
        $('.cls_price_lbl').html('Percentage');
    }
  });
});
</script>
