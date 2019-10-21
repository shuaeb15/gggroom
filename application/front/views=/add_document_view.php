<?php $this->load->view('templates/_include/header_view1'); ?>

<style media="screen">
  .image_preview_item img{
    width: auto;
    height: 201px;
  }
  .image_preview_item{
    margin-bottom: 30px;
  }
  .business_hrs{
    margin-bottom: 10px;
  }
  .cls-time-lable{
    width: 15% !important;
  }
  .cls-all-time{
    margin-bottom: 10px;
  }
  .cls-all-time p{
    font-size: 15px !important;
    line-height: 25px !important;
  }
  .cls-time-input{
    border-radius: 4px;
    text-align: left;
    border: solid 2px #008080;
    margin-bottom:10px;
    font-size: 20px;
  }
  input[type="checkbox"], input[type="radio"] {
    position: unset;
    right: 0px;
    width: 16px;
    height: 16px;
}
.cls-chk{
  font-size: 20px;
    margin-bottom: 18px;
}
.cls_all_service{
  margin-right: 10px !important;
  margin-left: 88px !important;
}
.cls_break_day_time{
  margin-right: 10px !important;
  margin-left: 88px !important;
}
.cl_lbl_time{
    width: 12%;
    font-size:21px;
}
.cl_lbl_end_time{
    width: 12%;
    font-size:21px;
    margin-left:70px;
}
.lbl_img{
  margin-top: 20px;
    padding: 10px;
    color: white !important;
}
.btn_image_add{
  border-color: rgb(37, 144, 144) !important;
  width: 90px !important;
}
@media only screen and (max-width:480px){
  .cl_lbl_time{
      width: 100%;
  }
  .cl_lbl_end_time{
      width: 100%;
      margin-left:0px;
  }
  .cls_day{
    width: 100% !important;
  }
  .cls_day label.css-label-check{
    margin-bottom: 0px !important;
  }
  .cls-chk{
    border-right: none !important;
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
          <form enctype="multipart/form-data" method="post" id="add_document" name="add_document" data-toggle="validator" action="<?php echo site_url("document/insert_document/"); ?>">
            <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
                <span class="form-title" style="float:none;font-size: 25px;margin: 0 auto 30px auto;">Add Document</span>
            </div>
            <div class="col-md-12">
              <div class="col-md-10 col-xs-12">
                <div class="form-group">
                  <label for="fname">Caption <span class="cls_star">*</span></label>
                  <input type="text" class="form-control" name="doc_caption" id="doc_caption">
                </div>
              </div>
              <div class="col-md-10 col-xs-12 cls_document">
                <div class="form-group">
                  <label for="fname">Document Type <span class="cls_star">*</span></label>
                  <select class="form-control" name="doc_type" id="doc_type">
                    <option value="">--Select--</option>
                    <?php foreach ($document_type as $val) {?>
                      <option value="<?=$val->id?>"><?=$val->name?></option>
                      <?php }?>
                  </select>
                </div>
              </div>
            </div>
            <hr class="hr_line">
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Document</span>
                <button type="button" id="OpenImgUpload" class="btn-default btn_border btn_add btn_image_add">Add</button>
                <input type="file" name="imgupload" id="imgupload" multiple style="display:none" onchange="readURL(this);"/>
            </div>
            <div class="col-md-12 col-xs-12 image_preview" style="margin-top:20px;text-align: -webkit-center;">
              <div class="row" id="uploaded_images">
                <!-- <img src="" alt="" id="preview_image" title="" class="img-responsive img-circle upload_img" style="width:200px;height:200px"/> -->
                <label class="lbl_img"></label>
              </div>
            </div>
            <div class="col-md-12 col-xs-12 cls_business_hours">
              <hr class="hr_line">
            </div>
            <div class="col-md-12 center_btn_main">
              <div class="center_btn_sub">
                <div class="center_btn_subitem">
                  <button type="button" class="dlt_shop_btn" id="btn-submit">Cancel</button>
                </div>
                <div class="center_btn_subitem">
                  <button type="submit" class="btn_document_submit save_shop_btn">Add Document</button>
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
$('#OpenImgUpload').click(function() { $('#imgupload').trigger('click'); });
  function readURL(input) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function (e) {
                      $('#preview_image').attr('src', e.target.result);
                  }
                  reader.readAsDataURL(input.files[0]);
              }
          }
          $('#btn-submit').click(function() {
            window.location.href = '<?php echo base_url();?>document';
          });
</script>

<script type="text/javascript">
$(document).ready(function(){
var _URL = window.URL || window.webkitURL;
$(document).on('change', "#imgupload", function () {
 var files = $('#imgupload')[0].files;
 var error = '';
 var form_data = new FormData();
 var name = files[0].name;
 $('.lbl_img').html(name);
 $('.lbl_img').css('border', '1px solid #059797');
 $('.lbl_img').css('background-color', '#059797');

 var imageSize = files[0].size;
 var extension = name.split('.').pop().toLowerCase();

 if(jQuery.inArray(extension, ['pdf','png','jpg','jpeg','tiff', 'tif']) == -1)
 {
    error += "Please select only pdf, png, jpg, jpeg, tif or tiff file"
 }
 if (imageSize > 10485760) {
   error += "Please select image size less than 10 MB"
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

  $(document).on('click', ".btn_document_submit", function () {
     var files = $('#imgupload').val();
     if(files == ''){
       swal({
             title: "",
             text: "Please select document",

         }, function () {
           $('html, body').animate({
                   scrollTop: $('.cls_document').offset().top
               }, 'slow');
         });
         return false;
     }
  });
});
</script>
