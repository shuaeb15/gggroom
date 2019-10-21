<?php $this->load->view('templates/_include/header_view1'); ?>

<style media="screen">
.dlt_shop_btn{
    width: 230px !important;
}
.save_shop_btn{
    width: 230px !important;
}
.cls_policy_p{
    margin: 0 !important;
    padding: 0 !important;
}
.sa-button-container button {
    width: auto !important;
    padding: 3px 16px !important;
  }
.btn_image_add{
  border-color: rgb(37, 144, 144) !important;
  width: 90px !important;
}
.image_preview_item img{
  width: auto;
  height: 201px;
}
.image_preview_item{
  margin-bottom: 30px;
}
.cls_btn_back{
  margin-left: -185px;
  margin-right: 10px;
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
  .cls_btn_back{
    margin-bottom: 30px;
    width: -1%;
    margin-left: -185px;
    margin-right: 5px;
    font-size: 16px;
    padding: 9px 17px;
  }
}

</style>
<?php $all_cat  = explode(',', $all_category);?>
<?php $all_cat_name  = explode(',', $all_category_name);?>
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

          <form enctype="multipart/form-data" method="post"  id="add_service" name="add_service" data-toggle="validator" action="<?php echo site_url("service/update_service"); ?>">
            <div class="col-xs-12 col-sm-12 col-md-12 css_title" style="text-align: center;">
              <a href="<?php echo base_url();?>service" class="btn btn-default cls_btn_back"><span>Go back</span></a>
                <span class="form-title" style="float:none;font-size: 25px;margin: 0 auto 30px auto;">Edit service</span>
            </div>
            <div class="image_change">
            <?php
            $img = $servicelist->image;
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
            }?>
            <input type="file" id="imgupload1" name="imgupload1" style="display:none" onchange="readURL(this);"/>
            <img src="<?=$main_image?>" alt="" id="preview_image" title="" class="img-responsive img-circle upload_img" />
            <a id="OpenImgUpload1"> <img src="<?=base_url()?>front/images/camera.png" alt="" title="" class="img-responsive img-circle camera_upload" /> </a>
            </div>
            <p class="imagechangetxt">Change Profile Image</p>
            <hr class="hr_line">

            <div class="col-md-12 col-xs-12">
              <span class="form-title">Service multiple photos</span>
                <button type="button" id="OpenImgUpload" class="btn-default btn_border btn_add btn_image_add">Add</button>
            </div>

            <div class="image_change">
              <input type="file" name="files" id="imgupload" multiple style="display:none" />
            </div>
            <div class="col-md-12 col-xs-12 image_preview">
              <div class="row" id="uploaded_images">
                <?php
                foreach ($shop_image_list as $key => $images) {?>
                  <?php
                  $img = $images->image;
                  $main_file = "assets/uploads/service_image/".$img;
                  $filename = FCPATH.$main_file;
                  if (file_exists($filename)) {
                    $main_image =  base_url().$main_file;
                  }else{
                    $main_image =  '';
                  }

                  if($main_image != ''){?>
                      <div class="col-md-4 col-xs-12 image_preview_item img_item<?=$images->id?>">
                        <img src="<?=$main_image?>" class="img-responsive">
                        <img src="<?=base_url()?>front/images/close.png" class="close image_delete" data-image-id="<?=$images->id?>">
                      </div>
                  <?php }}?>
                </div>
              </div>
              <hr class="hr_line">
            <div class="col-md-12 col-xs-12">
                <span class="form-title">Service Category <span class="cls_star">*</span></span>
            </div>
            <input type="hidden" name="service_id" id="service_id" value="<?=$servicelist->id?>"/>
            <div class="col-md-12 col-xs-12 service_category clas-main-category">
              <span class="form-title">Main Category</span>
              <div class="btn-group btn-group-maincat" data-toggle="buttons-radio">
                <?php
                foreach ($main_category as $cat) {?>
                    <button class="btn <?php if($all_cat[0] == $cat->category_id){ echo 'active';}?>" data-btn-id="<?=$cat->category_id?>"><?=$cat->cat_name?></button>
                    <?php if($all_cat[0] == $cat->category_id){?>
                          <input type="hidden" name="main_category" id="main_category" value="<?=$all_cat[0]?>">
                    <?php }?>
                  <?php }?>
              </div>
            </div>
            <div class="col-md-12 col-xs-12 service_category service_sub_category">
            </div>
            <div class="col-md-12 col-xs-12 service_category service_und_sub_category">
            </div>
            <div class="col-md-12 col-xs-12 service_category">
              <span class="form-title category_tree">
                <span class="firstcat"></span>
                <span class="seccat"> </span>
                <span class="thirdcat"> </span>
              </span>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line">
            </div>
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Service Type <span class="cls_star">*</span></span>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="row radio_policy">
                <?php $service_type = $servicelist->type;?>
                <!-- <div class="col-md-4 col-xs-12">
                  <input type="radio" name="radiog_dark_service_type" id="radio4" class="css-checkbox" <?php if($service_type ==  '1'){ echo 'checked';}?> value="1" />
                  <label for="radio4" class="css-label css-label-check radGroup1 radGroup2">
                    <p>Shop</p>
                    <span>Client will come to the shop</span>
                  </label>
                </div> -->
                <div class="col-md-4 col-xs-12">
                  <input type="checkbox" name="radiog_dark_service_type" id="radio5" class="css-checkbox" value="2" <?php if($service_type == 2){ echo 'checked';}?>/>
                  <label for="radio5" class="css-label css-label-check radGroup1 radGroup2">
                    <p class="cls_policy_p">Home</p>
                    <span>Provider will go to the client home</span>
                  </label>
                </div>
                <!-- <div class="col-md-4 col-xs-12">
                  <input type="radio" name="radiog_dark_service_type" id="radio6" class="css-checkbox" value="3" <?php if($service_type ==  '3'){ echo 'checked';}?>/>
                  <label for="radio6" class="css-label css-label-check radGroup1 radGroup2">
                    <p>Boths</p>
                    <span>We provide both the options.</span>
                  </label>
                </div> -->
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line">
            </div>
            <div class="col-md-12 col-xs-12">
              <span class="form-title cls_shop_detail">Shop Detail <span class="cls_star">*</span></span>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class=" radio_policy radio_list cls_all_shop">
                <?php
                if(!empty($shoplist)){
                $i = 7;
                foreach ($shoplist as $key => $shop) {
                  $i++;?>
                    <div class="col-md-12 col-xs-12 ">
                      <div class="radio_list_service">
                        <label for="radio7">
                          <p><?=$shop->shop_name?></p>
                          <span><?=$shop->addline1?><?php if($shop->addline2 != ''){ echo ', ';}?><?=$shop->addline2?><?php if($shop->city_name != ''){ echo ', ';}?><?=$shop->city_name?><?php if($shop->state_name != ''){ echo ', ';}?><?=$shop->state_name?><?php if($shop->zipcode != ''){ echo ', ';}?><?=$shop->zipcode?> </span>
                        </label>
                        <input type="radio" name="radiog_list_detail" id="radio<?=$i?>" class="css-checkbox" value="<?=$shop->id?>" <?php if($servicelist->shop_id == $shop->id){ echo 'checked';}?> />
                        <label for="radio<?=$i?>" class="css-label css-label-check shopRadioCheck" data-shopid="<?=$shop->id?>"></label>
                      </div>
                    </div>
                <?php }?>
              <?php }else{?>
                      <div class="col-md-12 col-xs-12">No shop added</div>
              <?php }?>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line">
            </div>
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Service Detail</span>
            </div>
            <div class="col-md-6 col-xs-12 service_range_slider margin_bottom_30">
              <div class="service_range_item service_range_price">
                <h2>Price ($) <span class="cls_star">*</span></h2>
                <input type="number" class="form-control" id="range-price" name="range-price" value="<?=$servicelist->price?>">
                <!-- <input type="range" value="<?=$servicelist->price?>" name="range-price" id="range-price" min="0" max="1000" data-rangeSlider> -->
                <div class="output"><output></output></div>
              </div>
              <!-- <div class="service_range_item">
                <h2>Time</h2>
                <input type="range" name="range-time" id="range-time" min="0" max="1000" value="<?=$servicelist->time?>" data-rangeSlider>
                <div class="output"><output></output>min</div>
              </div> -->
              <div class="service_range_item" id="timerange">
                  <h2>Time <span class="cls_star">*</span></h2>
                  <div class="col-md-2" style="text-align: right;cursor:pointer;">
                    <i class="fa fa-minus-circle" id="minusrange" style="font-size: 40px;color: #007c7d;"></i>
                  </div>
                  <div class="col-md-8" style="padding-top: 10px;cursor:pointer;">
                    <input type="range" id="timerangeinput" name="range-time" value="<?=$servicelist->time?>" min="0" step="10" max="1000" data-rangeSlider>
                    <div class="output"><output></output>min</div>
                  </div>
                  <div class="col-md-2" style="cursor:pointer;">
                    <i class="fa fa-plus-circle" id="plusrange" style="font-size: 40px;color: #007c7d;"></i>
                  </div>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line margin_bottom_30">
            </div>
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Select Worker <span class="cls_star">*</span></span>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="radio_policy radio_list">
                <div class="col-md-12 col-xs-12 ShopWorker">
                  <?php $j=100;
                  // echo '<pre>';print_r($workerlist);exit;
                    foreach ($workerlist as $key => $worker) {?>
                    <div class="radio_list_item css_worker_div worker" style="height:auto !important;">
                      <label for="radio10" class="col-md-12 col-xs-12">
                        <div class="col-md-6 col-xs-12 business_hrs_inner">
                          <span><?=$worker->name?></span>
                        </div>
                        <div class="col-md-6 col-xs-12 business_hrs_inner"></div>
                      </label>
                      <?php $worker_mainid = explode(',', $servicelist->worker_id);?>
                      <input type="checkbox" name="radiog_list_worker_time[]" id="radio<?=$j?>" <?php if($worker_mainid != ''){  foreach ($worker_mainid as $wor_id) { if($wor_id == $worker->id){ echo 'checked';}}}else{ if($key == '0'){ echo 'checked';}}?> value="<?=$worker->id?>" class="css-checkbox" />
                      <label for="radio<?=$j?>" class="css-label css-label-check"></label>
                  </div>
                  <?php $j++;}?>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-xs-12" style="margin-top:50px;">
              <hr class="hr_line margin_bottom_30">
            </div>
            <div class="col-md-12 center_btn_main">
              <div class="center_btn_sub">
                <div class="center_btn_subitem">
                  <button type="button" class="dlt_shop_btn" onclick="delete_shop();">Delete Service</button>
                </div>
                <div class="center_btn_subitem">
                  <button type="submit" class="save_shop_btn btn_save_services">Save Changes</button>
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
$('#OpenImgUpload1').click(function() { $('#imgupload1').trigger('click'); });
  function readURL(input) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function (e) {
                      $('#preview_image').attr('src', e.target.result);
                  }
                  reader.readAsDataURL(input.files[0]);
              }
          }
</script>

<script type="text/javascript">
$(document).ready(function(){
var _URL = window.URL || window.webkitURL;
$(document).on('change', "#imgupload1", function () {
  $('.css_title').css('margin-bottom', '0px');
 var files = $('#imgupload1')[0].files;
 var error = '';
 var form_data = new FormData();
 var image_width = 485;
 // var image_height = 485;

 var name = files[0].name;
 var imageSize = files[0].size;
 var extension = name.split('.').pop().toLowerCase();

 if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
 {
    $('.css_title').css('margin-bottom', '50px');
    error += "Please select only gif, png, jpg or jpeg file"
 }
 if (imageSize > 2097152) {
   $('.css_title').css('margin-bottom', '50px');
   error += "Please select image size less than 2 MB"
 }

 if(error != '')
 {
   swal({
         title: "",
         text: error,

     }, function () {
       $("#preview_image").attr("src","")

     })
     return false;
   }
  });
});
</script>

<script type="text/javascript">
  function delete_shop() {
    var service_id  = $('#service_id').val();
    window.location.href = '<?php echo base_url(); ?>service/delete_service/'+service_id;
  }
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('#OpenImgUpload').click(function() { $('#imgupload').trigger('click'); });

  $(document).on('change', "#imgupload", function () {
  var files = $('#imgupload')[0].files;
  var service_id  = $('#service_id').val();
  var error = '';
  var form_data = new FormData();

  for(var count = 0; count<files.length; count++)
  {
   var name = files[count].name;
   var imageSize = files[count].size;
   var extension = name.split('.').pop().toLowerCase();
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
   {
    error += "Please select only gif, png, jpg or jpeg file"
   }
   else if (imageSize > 2097152) {
     error += "Please select image size less than 2 MB"
   }
   else
   {
    form_data.append("files[]", files[count]);
   }
  }

  if(error == '')
  {
   $.ajax({
    url:"<?php echo base_url(); ?>service/upload/"+service_id,
    method:"POST",
    data:form_data,
    contentType:false,
    cache:false,
    processData:false,
    success:function(data)
    {
      var data1 = JSON.parse(data);
      console.log(data1);

      for (var i = 0; i < data1.length; i++) {
          $('#uploaded_images').append('<div class="col-md-4 col-xs-12 image_preview_item img_item'+data1[i].id+'"><img src="<?php echo base_url();?>assets/uploads/service_image/'+data1[i].image+'" class="img-responsive"><img src="<?php echo base_url()?>front/images/close.png" class="close image_delete" data-image-id="'+data1[i].id+'"></div>');
      }
     $('#imgupload').val('');
    }
   })
  }
  else
  {
    swal({
          title: "",
          text: error,

      }, function () {
      })
  }
 });
});
</script>


<script type="text/javascript">
$(document).ready(function(){
  $(document).on('click', ".image_delete", function () {
  // $('.image_delete').click(function() {
    var img_id = $(this).attr('data-image-id');

    swal({
      title: "Are you sure?",
      text: "You want to delete this image",
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
            url: "<?php echo base_url(); ?>service/delete_image",
            type: 'post',
            data: {img_id:img_id},
            success: function (data) {
              $( ".img_item"+img_id ).remove();
              // swal("Deleted!", "Your image has been deleted.", "success");
            },

        });
      } else {
        // swal("Cancelled", "image not deleted", "error");
      }
    });
  });
});
</script>

<script type="text/javascript">
var firstcat = null;
var secondcat = null;
var thirdcat = null;
$(document).on('click', ".btn-group-maincat > button.btn", function () {
    $("#overlay").show();
    firstcat = this.innerHTML;
    $(".btn-group-maincat > button.btn").removeClass("active");
    $(".category_tree .firstcat").html(firstcat + " > ");
    $(".btn-group-mainsubcat > button.btn").removeClass("active");
    $(".category_tree .seccat").html('');
    $(".btn-group-subcat > button.btn").removeClass("active");
    $(".category_tree span.thirdcat").html('');
    $('.sub_category').remove();
    $('.und_sub_category').remove();
    $(".btn-group-mainsubcat:first").remove();
    var cat_id = $(this).attr('data-btn-id');
    $('#main_category').val(cat_id);
    var flag = '1';

        $.ajax({
            url: "<?php echo base_url(); ?>service/get_sub_category/"+flag,
            type: 'post',
            data: {cat_id:cat_id},
            success: function (data) {
              var cat_data = JSON.parse(data);
              $('.span-form-title').remove();

              $('.btn-group-mainsubcat > button.btn').remove();
              $('.span-form-title1').remove();
              $('.btn-group-subcat > button.btn').remove();
              var test = '<span class="form-title span-form-title">Sub Category</span><div class="btn-group btn-group-mainsubcat" data-toggle="buttons-radio">';
                for (var i = 0; i < cat_data.length; i++) {
                  test += '<button type="button" class="btn" data-sub-btn-id="'+cat_data[i].category_id+'">'+cat_data[i].cat_name+'</button>';
                }
                var maintest = test+'</div><input type="hidden" class="sub_category" name="sub_category" id="sub_category" value="">';
                if(cat_data.length != 0){
                    $('.service_sub_category').append(maintest);
                }
                $("#overlay").hide();
            },
        });
});

$(document).on('click', ".btn-group-mainsubcat > button.btn", function () {
    secondcat = this.innerHTML;
    $("#overlay").show();
    $(".btn-group-mainsubcat > button.btn").removeClass("active");
    $(".category_tree .seccat").html(secondcat);
    $(".btn-group-subcat > button.btn").removeClass("active");
    $(".category_tree span.thirdcat").html('');
    $('.und_sub_category').remove();
    $(".btn-group-subcat:first").remove();

    var cat_id1 = $(this).attr('data-sub-btn-id');
    $('#sub_category').val(cat_id1);
    var flag = '2';
    $.ajax({
        url: "<?php echo base_url(); ?>service/get_sub_category/"+flag,
        type: 'post',
        data: {cat_id:cat_id1},
        success: function (data) {
          var cat_data = JSON.parse(data);

          $('.span-form-title1').remove();
          $('.btn-group-subcat > button.btn').remove();
          var test = '<span class="form-title span-form-title1">Sub Category</span><div class="btn-group btn-group-subcat" data-toggle="buttons-radio">';
            for (var i = 0; i < cat_data.length; i++) {
              test += '<button type="button" class="btn" data-und-sub-btn-id="'+cat_data[i].category_id+'">'+cat_data[i].cat_name+'</button>';
            }
            var maintest = test+'</div><input type="hidden" name="und_sub_category" class="und_sub_category" id="und_sub_category" value="">';
            if(cat_data.length != 0){
                $('.service_und_sub_category').append(maintest);
            }
            $("#overlay").hide();
        },
    });
});

$(document).on('click', ".btn-group-subcat > button.btn", function () {
    thirdcat = this.innerHTML;
    $(".btn-group-subcat > button.btn").removeClass("active");
    $(".category_tree span.thirdcat").html("> " + thirdcat);

    var cat_id = $(this).attr('data-und-sub-btn-id');
    $('#und_sub_category').val(cat_id);
});
</script>


<script>
(function () {

var selector = '[data-rangeSlider]',
  elements = document.querySelectorAll(selector);
 var changeValBtn = document.querySelector('#timerange');
 var plusrange = document.getElementById('plusrange');
 plusrange.addEventListener('click', function (e) {
            var inputRange = changeValBtn.parentNode.querySelector('input[type="range"]'),
                // value = changeValBtn.parentNode.querySelector('input[type="number"]').value;
                value = parseInt($('#timerangeinput').val())+10;
            inputRange.value = value;
            inputRange.dispatchEvent(new Event('change'));
        }, false);

 var minusrange = document.getElementById('minusrange');
 minusrange.addEventListener('click', function (e) {
            var inputRange = changeValBtn.parentNode.querySelector('input[type="range"]'),
                // value = changeValBtn.parentNode.querySelector('input[type="number"]').value;
                value = parseInt($('#timerangeinput').val())-10;
            inputRange.value = value;
            inputRange.dispatchEvent(new Event('change'));
        }, false);
// Example functionality to demonstrate a value feedback
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

<script type="text/javascript">
setTimeout(function(){
  var val1 = $('#main_category').val();
  var val2 = $('#sub_category').val();
  var val3 = $('#und_sub_category').val();

  if(val1 != '' && val2 == undefined && val3 == undefined){
    var myVar = $('.btn-group-maincat > .active').html();
    $(".category_tree .firstcat").html(myVar);
  }
  else if(val1 != '' && val2 != '' && val3 == undefined){
    var myVar = $('.btn-group-maincat > .active').html();
    $(".category_tree .firstcat").html(myVar + " > ");
    var myVar1 = $('.btn-group-mainsubcat > .active').html();
    $(".category_tree .seccat").html(myVar1);
  }
  else if(val1 != '' && val2 != '' && val3 != ''){
    var myVar = $('.btn-group-maincat > .active').html();
    $(".category_tree .firstcat").html(myVar + " > ");
    var myVar1 = $('.btn-group-mainsubcat > .active').html();
    $(".category_tree .seccat").html(myVar1 + " > ");
    var myVar2 = $('.btn-group-subcat > .active').html();
    $(".category_tree .thirdcat").html(myVar2);
  }
}, 500);
  var parent_cat_name = '<?php echo $all_cat_name[0];?>';
  var sub_cat_name = '<?php echo $all_cat_name[1];?>';
  var child_cat_name = '<?php echo $all_cat_name[2];?>';
  if(parent_cat_name != ''){
    $(".category_tree .firstcat").html(parent_cat_name);
  }
  if(sub_cat_name != ''){
    $(".category_tree .seccat").html("> " +sub_cat_name);
  }
  if(child_cat_name != ''){
    $(".category_tree .thirdcat").html("> " +child_cat_name);
  }
  var cat_main = '<?php echo $all_cat[0];?>';
  if(cat_main != '' ){
    var cat_id = cat_main;
    var flag = '1';
        $.ajax({
            url: "<?php echo base_url(); ?>service/get_sub_category/"+flag,
            type: 'post',
            data: {cat_id:cat_id},
            success: function (data) {
              var cat_data = JSON.parse(data);
              console.log(cat_data);
              $('.span-form-title').remove();
              $('.btn-group-mainsubcat > button.btn').remove();
              $('.span-form-title1').remove();
              $('.btn-group-subcat > button.btn').remove();
              var test = '<span class="form-title span-form-title">Sub Category</span><div class="btn-group btn-group-mainsubcat" data-toggle="buttons-radio">';
              var test1;
              var cat_sub = '<?php echo $all_cat[1];?>';
                for (var i = 0; i < cat_data.length; i++) {
                  if(cat_sub == cat_data[i].category_id){
                    var cls = 'active';
                    var cls1 = '<input type="hidden" name="sub_category" id="sub_category" value="'+cat_sub+'">';
                  }
                  else {
                    var cls = '';
                    var cls1 = '';
                  }
                    test += '<button class="btn '+cls+'" data-sub-btn-id="'+cat_data[i].category_id+'">'+cat_data[i].cat_name+'</button>'+cls1;
                }
                var maintest = test+'</div>';
                if(cat_data.length != 0){
                    $('.service_sub_category').append(maintest);
                }
                var cat_main1 = '<?php echo $all_cat[1];?>';
                if(cat_main1 != ''){
                  var cat_id = cat_main1;
                  var flag = '2';
                  $.ajax({
                      url: "<?php echo base_url(); ?>service/get_sub_category/"+flag,
                      type: 'post',
                      data: {cat_id:cat_id},
                      success: function (data) {
                        var cat_data = JSON.parse(data);
                        $('.span-form-title1').remove();
                        $('.btn-group-subcat > button.btn').remove();
                        var test = '<span class="form-title span-form-title1">Sub Category</span><div class="btn-group btn-group-subcat" data-toggle="buttons-radio">';

                        var cat_sub1 = '<?php echo $all_cat[2];?>';
                          for (var i = 0; i < cat_data.length; i++) {
                            if(cat_sub1 == cat_data[i].category_id){
                              var cls = 'active';
                              var cls1 = '<input type="hidden" name="und_sub_category" id="und_sub_category" value="'+cat_data[i].category_id+'">';
                            }
                            else {
                              var cls = '';
                              var cls1 = '';
                            }
                            test += '<button class="btn '+cls+'" data-und-sub-btn-id="'+cat_data[i].category_id+'">'+cat_data[i].cat_name+'</button>'+cls1;
                            // $(".category_tree .thirdcat").html("> " +cat_data[i].cat_name);
                          }
                          var maintest = test+'</div>';
                          if(cat_data.length != 0){
                              $('.service_und_sub_category').append(maintest);
                          }
                      },
                    });
                }
            },
        });
  }

</script>
