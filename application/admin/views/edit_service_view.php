<?php $this->load->view('templates/_include/admin_main_sidebar_view'); ?>

<link href="<?php echo base_url('../front/css/gggroom.css?ver=1.3');?>" rel="stylesheet">
<style media="screen">
.cls_shop_info{
  height: 36px;
border-radius: 4px;
text-align: left;
font-size: 14px;
/* background: #f3f3f3; */
margin-left: 10px;
}
.cls_lable_info{
  margin-top: 8px;
    font-weight: 100;
}
.cls-chk1{
	font-size: 25px !important;
}
.cls-chk1 input{
	width: 17px !important;
  height: 17px !important;
  margin-right: 6px !important;
}
.cls_shop_lable{
  width: 17px !important;
height: 17px !important;
float:right;
}
.cls_label_list p{
  font-size: 18px;
  font-weight: 100;
}

.cls_worker_lable{
  width: 17px !important;
height: 17px !important;
float:right;
}
.camera_upload{
  margin-top: -27px;
  margin-left: 93px;
  width: 35px;
}
.upload_img{
  width: 150px;
    height: 150px;
}
@media only screen and (max-width:480px){
.cls_all_field{
      width:100%;
  }
  .cls_shop_lable{
    margin-left: 15px !important;
  }
  .cls_worker_lable{
      margin-left: 15px !important;
  }
  .cls_md_10{
    padding-left: 0px;
        width: 70%;
  }
  .radio_list_item{
    padding-right: 0px;
  }
  .cls_md_7{
    width: 85%;
  }
}
</style>
<div class="right_col" role="main" style="min-height: 959px;">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Service</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <form enctype="multipart/form-data" method="post"  id="edit_shop1" name="edit_shop1" data-toggle="validator" action="<?=base_url()?>service/update_service/<?php if(isset($service_data->encrypt_id)){ echo $service_data->encrypt_id;}?>">
            <input type="hidden" class="form-control cls_lable_info" name="service_id" id="service_id" value="<?php if(isset($service_data->id)){ echo $service_data->id;}?>">
            <input type="hidden" class="form-control cls_lable_info" name="worker_id" id="worker_id" value="<?php if(isset($service_data->worker_id)){ echo $service_data->worker_id;}?>">
            <input type="hidden" class="form-control cls_lable_info" name="user_id" id="user_id" value="<?php if(isset($service_data->user_id)){ echo $service_data->user_id;}?>">
          <div class="x_title">
            <h2>Edit Service</h2>
            <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="image_change">
            <?php
             if(isset($service_data->image)){
               $img = $service_data->image;
             }else{
               $img = '';
             }
            $temp_file = base_url()."../front/images/banner.jpg";
            $main_file = "../assets/uploads/service_image/".$img;
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
                <input type="file" id="imgupload1" name="imgupload1" style="display:none" />
                <img src="<?=$main_image?>" alt="" id="preview_image" title="" class="img-responsive img-circle upload_img" />
                <a id="OpenImgUpload1"> <img src="<?=base_url()?>../front/images/camera.png" alt="" title="" class="img-responsive img-circle camera_upload" /> </a>
            </div>
            <p class="imagechangetxt">Change Image</p>
            <hr class="hr_line">
            <div class="col-md-12 cls_all_field">
              <div class="item form-group">
               <label class="control-label1 col-xs-12" for="product">Select Category</label><br>
                <div class="col-md-12 cls_shop_info cls_all_field" style="<?php if(!empty($sub_cat_list)){  echo 'margin-bottom: 31px';}?>">
                  <div class="item form-group">
                    <label class="control-label1 col-xs-12" for="product">Parent category</label><br>
                     <div class="col-xs-7 cls_all_field">
                       <select class="cat_id form-control" name="parent_category" id="parent_category">
                         <option value="">select</option>
                         <?php
                         foreach ($category_list as $key => $cat_list) {?>
                            <option <?php if($service_data->main_sub_cat_id == $cat_list->category_id){ echo 'selected';}?> value=<?=$cat_list->category_id?>><?=$cat_list->cat_name?></option>
                         <?php }?>
                       </select>
                     </div>
                   </div>
                 </div>
                 <div class="col-md-12 cls_shop_info cls_all_field" style="<?php if(!empty($sub_cat_list)){  echo 'margin-bottom: 31px';}?>">
                   <div class="item form-group clas-main-category">
                     <?php
                       if(!empty($sub_cat_list)){?>
                     <label class="control-label1 col-xs-12" for="product">Sub category</label><br>
                      <div class="col-xs-7 cls_all_field">
                        <select class="cat_id form-control" name="sub_category" id="sub_category">
                              <option value="">select</option>
                              <?php foreach ($sub_cat_list as $key => $cat_list) {?>
                                       <option <?php if($service_data->sub_cat_id == $cat_list['category_id']){ echo 'selected';}?> value=<?=$cat_list['category_id']?>><?=$cat_list['cat_name']?></option>
                              <?php }?>
                        </select>
                      </div>
                    <?php }?>
                    </div>
                  </div>
                  <div class="col-md-12 cls_shop_info cls_all_field" style="<?php if(!empty($und_cat_list)){  echo 'margin-bottom: 50px';}?>">
                    <div class="item form-group " id="und_main_sub_category">
                      <?php
                          if(!empty($und_cat_list)){?>
                            <label class="control-label1 col-xs-12 cls_p_cat" for="product">Child category</label><br>
                             <div class="col-xs-7 cls_all_field">
                               <select class="cat_id form-control" name="und_sub_category" id="und_sub_category">
                                 <option value="">select</option>
                                 <?php foreach ($und_cat_list as $key => $cat_list) {?>
                                          <option <?php if($service_data->und_sub_cat_id == $cat_list['category_id']  ){ echo 'selected';}?> value=<?=$cat_list['category_id']?>><?=$cat_list['cat_name']?></option>
                                 <?php }?>
                               </select>
                             </div>
                          <?php }?>
                     </div>
                </div>
               </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 40px;">
              <div class="col-md-7 cls_main cls_all_field" style="margin-bottom: 20px;">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Price ($)</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="number" class="form-control cls_lable_info" name="range-price" id="range-price" value="<?=$service_data->price?>">
                  </div>
                 </div>
              </div>
              <div class="col-md-7 cls_main cls_all_field">
                <div class="item form-group">
                 <label class="control-label1 col-xs-12" for="product">Time (min)</label><br>
                  <div class="col-md-12 cls_shop_info cls_all_field">
                    <input type="number" class="form-control cls_lable_info" name="range-time" id="range-time" value="<?=$service_data->time?>">
                  </div>
                 </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-12 col-xs-12 cls-time-title">
                <label class="control-label1 col-xs-12" for="product" style="font-size: 25px;">Service type</label><br>
              </div>
              <div class="col-md-12 col-xs-12">
                <div class="cls-chk1">
                  <?php $type = $service_data->type;?>
                  <label style="font-size: 18px !important;font-weight:100;">
                  <input type="radio" name="radiog_dark_service_type" id="radiog_dark_service_type" <?php if($type == '2'){ echo 'checked';}else if($type == ''){ echo 'checked';}?> value="2" >Home</label>
                </div>
              </div>
            </div>
            <hr class="hr_line">
            <div class="row cls_shop_detail" id="uploaded_images">
              <div class="col-md-12 col-xs-12 cls-time-title">
                <label class="control-label1 col-xs-12" for="product" style="font-size: 25px;">Shop Detail</label><br>
              </div>
              <?php
              if(!empty($shoplist)){
                  $i = 0;
                foreach ($shoplist as $key => $shop) {
                  $i++;?>
                    <div class="col-md-7 cls_md_7" style="margin-left: 25px;">
                      <div class="radio_list_item">
                        <div class="col-md-10 cls_md_10">
                          <label class="cls_label_list">
                            <p><?=$shop->shop_name?></p>
                          </label>
                        </div>
                        <div class="col-md-2">
                          <input type="radio" name="radiog_list_detail" id="radio<?=$i?>" value="<?=$shop->id?>" <?php if($service_data->shop_id == $shop->id){ echo 'checked';}?> class="cls_shop_lable" data-shopid="<?=$shop->id?>" data-userid="<?=$shop->user_id?>"/>
                       </div>
                      </div>
                    </div>
                <?php }?>
              <?php }else{?>
                  <p>No shop added</p>
              <?php }?>
              </div>
              <hr class="hr_line">
              <div class="row" id="uploaded_images">
                <div class="col-md-12 col-xs-12 cls-time-title">
                  <label class="control-label1 col-xs-12" for="product" style="font-size: 25px;">Select Worker</label><br>
                </div>
                <div class="ShopWorker" style="margin-left: 25px;">
                  <?php $j=100;
                  if(!empty($worker_list)){
                    foreach ($worker_list as $key => $worker) {?>
                      <?php $worker_mainid = explode(',', $service_data->worker_id);?>
                      <div class="col-md-7 cls_md_7">
                        <div class="radio_list_item">
                          <div class="col-md-10 cls_md_10">
                             <label class="cls_label_list">
                              <p><?=$worker->name?></p>
                             </label>
                          </div>
                          <div class="col-md-2">
                             <input type="checkbox" name="radiog_list_worker_time[]" id="radio<?=$j?>" value="<?=$worker->id?>" class="cls_worker_lable" <?php if($worker_mainid != ''){  foreach ($worker_mainid as $wor_id) { if($wor_id == $worker->id){ echo 'checked';}}}else{ if($key == '0'){ echo 'checked';}}?>/>
                          </div>
                        </div>
                      </div>
                    <?php $j++;}?>
                  <?php }else{?>
                      <p>No Worker for selected shop</p>
                  <?php }?>
                </div>
              </div>
              <hr class="hr_line">
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <input type="button" onclick="location.href = '<?php echo base_url(); ?>service'" class="btn btn-primary" value="Cancel">
                  <button id="send" type="submit" class="btn btn-success edit_shop_btn">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$('.cls_break_day_time').prop('checked', true);
$('.cls_all_service').prop('checked', true);

<?php if(!empty($business_hours)){?>
        $('#cls-day-time').hide();
<?php }else{?>
        $('.img_business').attr('src','<?php echo base_url(); ?>../front/images/delete.png');
<?php }?>
<?php if(!empty($breaks)){?>
          $('#cls-breaks-time').hide();
<?php }else{?>
          $('.img_break').attr('src','<?php echo base_url(); ?>../front/images/delete.png');
<?php }?>

</script>

<script type="text/javascript">
$('#OpenImgUpload1').click(function() { $('#imgupload1').trigger('click'); });
</script>

<script type="text/javascript">
$(document).ready(function(){
var _URL = window.URL || window.webkitURL;
$(document).on('change', "#imgupload1", function () {
  if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          $('#preview_image').attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
  }

  // $('#preview_image').attr('src', img_val);
  // alert(img_val);

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
    error += "Please select only gif, png, jpg or jpeg file"
 }
 if (imageSize > 2097152) {
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
  var site_url = $("#site_url").val();
</script>

<script type="text/javascript">
$(".cls_shop_lable").click(function(event) {
  var form_data = [{"name": "shopid","value": $(this).attr('data-shopid')},{"name": "userid","value": $(this).attr('data-userid')}];
  $.ajax({
      url: site_url + 'service/GetShopWorkerData',
      type: "POST",
      data: form_data,
      success: function(data) {
          $(".ShopWorker").html(data);
      }
  });
});

// var radioValue = $("input[name='radiog_list_detail']:checked").val();
// var worker_id = $("#worker_id").val();
//
// var form_data = [{"name": "shopid","value": radioValue},{"name": "worker_id","value": worker_id}];
// $.ajax({
//     url: site_url + 'service/GetShopWorkerData',
//     type: "POST",
//     data: form_data,
//     success: function(data) {
//         $(".ShopWorker").html(data);
//     }
// });
</script>

<script type="text/javascript">
$("#parent_category").change(function(event) {
  var cat = $('#parent_category').val();
  var form_data = 'parent_id='+cat;
  $.ajax({
      url: site_url + 'service/get_sub_cat',
      type: "POST",
      data: form_data,
      success: function(data) {

          $("#sub_category").html(data);
          $("#und_main_sub_category").html('');
      }
  });
});

$("#sub_category").change(function() {
  var cat = $('#sub_category').val();
  var form_data = 'sub_id='+cat;
  $.ajax({
      url: site_url + 'service/get_und_sub_cat',
      type: "POST",
      data: form_data,
      success: function(data) {

          $("#und_main_sub_category").html(data);
      }
  });
});

$(document).on('click', ".edit_shop_btn", function () {
  // if($(".span-form-title").is(':visible')){
  var sub_category = $('#sub_category').val();
    if (sub_category == '') {
      swal({
            title: "",
            text: "Please select sub category",

        }, function () {
          $('html, body').animate({
                  scrollTop: $('.clas-main-category').offset().top
              }, 'slow');
        })
        return false;
      }
    // }

    if($(".cls_p_cat").is(':visible')){
      var und_sub_category = $('#und_sub_category').val();
      if (und_sub_category == '') {
        swal({
              title: "",
              text: "Please select sub category",

          }, function () {
            $('html, body').animate({
                    scrollTop: $('#und_main_sub_category').offset().top
                }, 'slow');
          })
          return false;
        }
      }

      if(!$('input[name=radiog_list_detail]:checked').length > 0){
        swal({
              title: "",
              text: "Please select shop",

          }, function () {
            $('html, body').animate({
                    scrollTop: $('.cls_shop_detail').offset().top
                }, 'slow');
          })
          return false;
      }

      var price = $('#range-price').val();
      if(price == ''){
        swal({
              title: "",
              text: "Please enter price",

          }, function () {
            $('html, body').animate({
                    scrollTop: $('.service_range_slider').offset().top
                }, 'slow');
          })
          return false;
      }

        if(!$('input[type=checkbox]:checked').length > 0){
          // alert('fdgfdg');
          swal({
                title: "",
                text: "Please select worker",

            }, function () {
              // $('html, body').animate({
              //         scrollTop: $('.cls_shop_detail').offset().top
              //     }, 'slow');
            })
            return false;
        }
});
</script>
