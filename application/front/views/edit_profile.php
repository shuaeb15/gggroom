<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
.dlt_shop_btn{
    /* width: 230px !important; */
}
.save_shop_btn{
  padding: 6px 50px !important;
    width: 184px !important;
}
.col-md-6 {
    width: 50% !important;
}
@media only screen and (max-width:480px){
  .radio_main_div {
    max-width: 100%;
 }
 .css-label{
   margin-right: 14px !important;
 }
 .col-md-6 {
    width: 100% !important;
}
.edit-form{
  padding: 20px 5px !important;
}
}
</style>
<section class="block">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="edit-form">
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
                  $img = $userlist->image;
                  $temp_file = base_url()."front/images/user.png";
                  $main_file = "assets/uploads/profile_image/".$img;
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
                    <span class="form-title">BASIC INFORMATION</span>
                    <form action="<?php echo site_url("profile/update_user"); ?>" enctype="multipart/form-data" method="post" id="edit_user" name="edit_user" data-toggle="validator">
                        <div class="image_change">
                            <input type="file" id="imgupload" name="imgupload" style="display:none" onchange="readURL(this);"/>
                            <img src="<?=$main_image?>" alt="" id="preview_image" title="" class="img-responsive img-circle upload_img" style="object-fit:cover;"/>
                            <a id="OpenImgUpload"> <img src="<?=base_url()?>front/images/camera.png" alt="" title="" class="img-responsive img-circle camera_upload" /> </a>
                        </div>
                        <p class="imagechangetxt">Change Image</p>
                        <hr class="hr_line">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="fname">First Name <span class="cls_star">*</span></label>
                                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $userlist->firstname;?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="lname">Last Name <span class="cls_star">*</span></label>
                                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $userlist->lastname;?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12" style="clear:both;">
                            <div class="form-group">
                                <label for="uname">Email <span class="cls_star">*</span></label>
                                <input type="email" class="form-control" id="u_email" name="u_email" value="<?php echo $userlist->email;?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="email">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $userlist->mobile;?>">
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label for="pwd">Address Line 1</label>
                                <input type="text" class="form-control" id="address1" name="address1" value="<?php echo $userlist->address1;?>">
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label for="cpwd">Address Line 2</label>
                                <input type="text" class="form-control" id="address2" name="address2" value="<?php echo $userlist->address2;?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="uname">City</label>
                                <select class="city form-control" id="city" name="city">
                                  <option value="">--Select--</option>
                                  <?php foreach ($city as $val) {?>
                                    <option <?php if($userlist->city == $val->id){ echo 'selected'; }?> value="<?=$val->id?>"><?=$val->name?></option>
                                    <?php }?>
                                </select>
                                <!-- <input type="text" class="form-control" id="city" name="city" value="<?php echo $userlist->city_name;?>"> -->
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="email">State</label>
                                        <select class="form-control" id="state" name="state">
                                          <?php $state_edit = $userlist->state;?>
                                          <option value="">--Select--</option>
                                          <?php foreach ($state as $val) {?>
                                            <option <?php if($state_edit == $val->id){ echo 'selected';}?> value="<?=$val->id;?>"><?=$val->name;?></option>
                                            <?php }?>
                                      </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Zip code</label>
                                        <input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo $userlist->zipcode;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group">
                            <label for="gender">Gender <span class="cls_star">*</span></label>
                            <select class="form-control" id="radio_gender" name="radio_gender" value="<?=$userlist->gender?>">
                              <option value="Female">Female</option>
                              <option value="Male">Male</option>
                              <option value="Rather not say">Rather not say</option>
                            </select>
                          </div>
                      </div>
                    <div class="col-md-8 col-xs-12" style="margin-top: 10px;margin-bottom: 20px;">
                      <div class="item form-group cls_radio_btn">
                         <div class="col-xs-12 cls-chk" style="font-size: 19px !important;">
                           <input type="radio" name="u_chk" id="radio7" class="css-checkbox u_chk" <?php if($userlist->u_category == '1'){ echo 'checked';}?> value="1"/>
                           <label for="radio7" class="css-label css-label-check radGroup1 radGroup2">
                             <span style="font-size: 20px;color: #059797;">Client</span>
                           </label>
                           <input type="radio" name="u_chk" id="radio8" class="css-checkbox u_chk" value="2" <?php if($userlist->u_category == '2'){ echo 'checked';}?>/>
                           <label for="radio8" class="css-label css-label-check radGroup1 radGroup2">
                             <span style="font-size: 20px;color: #059797;">Professional</span>
                           </label>
                          <?php if($userlist->u_category == '3'){?>
                           <input type="radio" name="u_chk" id="radio9" class="css-checkbox u_chk" value="3" <?php if($userlist->u_category == '3'){ echo 'checked';}?>/>
                           <label for="radio9" class="css-label css-label-check radGroup1 radGroup2">
                             <span style="font-size: 20px;color: #059797;">Worker</span>
                           </label>
                         <?php }?>
                         </div>
                       </div>

                        <!-- <div class="form-group">
                          <div class="form-check" style="width: 20%;">
                              <label>
                                  <input type="radio" name="u_chk" id="u_chk" <?php if($userlist->u_category == '1'){ echo 'checked';}?> value="1"> <span class="label-text" style="font-size: 20px;">Client</span>
                              </label>
                          </div>
                          <div class="form-check" style="width: 30%;">
                              <label>
                                  <input type="radio" name="u_chk" id="u_chk" value="2" <?php if($userlist->u_category == '2'){ echo 'checked';}?>> <span class="label-text" style="font-size: 20px;">Professional</span>
                              </label>
                          </div>
                          <?php if($userlist->u_category == '3'){?>
                            <div class="form-check" style="width: 30%;">
                                <label>
                                    <input type="radio" name="u_chk" id="u_chk" value="3" <?php if($userlist->u_category == '3'){ echo 'checked';}?>> <span class="label-text" style="font-size: 20px;">Worker</span>
                                </label>
                            </div>
                          <?php }?>
                        </div> -->
                    </div>
                    <div class="col-md-12 center_btn_main">
                      <div class="center_btn_sub">
                        <div class="center_btn_subitem" style="margin-top: 25px;">
                          <?php if (!empty($this->session->userdata('setting_page'))) { ?>
                            <a href="<?php echo base_url('setting'); ?>" class="dlt_shop_btn">Cancel</a>
                          <?php }else{?>
                                <a href="<?php echo base_url('profile'); ?>" class="dlt_shop_btn">Cancel</a>
                        <?php  }?>
                        </div>
                        <div class="center_btn_subitem">
                          <button type="submit" class="full-width-btn emboss-btn save_shop_btn btn_save_services">Save</button>
                        </div>
                      </div>
                    </div>
                        <!-- <div class="col-md-12">
                            <div class="col-md-6 col-xs-12">
                              <?php if (!empty($this->session->userdata('setting_page'))) { ?>
                                <a href="<?php echo base_url('setting'); ?>" class="dlt_shop_btn">Cancel</a>
                              <?php }else{?>
                                    <a href="<?php echo base_url('profile'); ?>" class="dlt_shop_btn">Cancel</a>
                            <?php  }?>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <button type="submit" class="full-width-btn emboss-btn save_shop_btn btn_save_services">Save</button>
                        </div>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
$( document ).ready(function() {
  $('#radio_gender').editableSelect({ filter: true});
});
  var site_url = $("#site_url").val();
</script>
<script type="text/javascript">
$(document).ready(function() {
$("#city").autocomplete({
      source: function( request, response ) {
          $.ajax( {
              url: site_url + 'profile/Get_city_Data',
              type: "POST",
              dataType: "json",
              data: {
              term: request.term,
              },
              success: function( data ) {
                  response( data );
              }
          } );
      }
  });
});
</script>
<script type="text/javascript">
$('html, body').animate({
        scrollTop: $('#preview_image').offset().top
    }, 'slow');

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
            window.location.href = '../';
          });

</script>

<script type="text/javascript">
$(document).ready(function(){
var _URL = window.URL || window.webkitURL;
$(document).on('change', "#imgupload", function () {
 var files = $('#imgupload')[0].files;
 var error = '';
 var form_data = new FormData();
 var image_width = 485;
 var image_height = 325;

 var name = files[0].name;
 var imageSize = files[0].size;
 var extension = name.split('.').pop().toLowerCase();

 var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
            var wid = this.width;
            var ht = this.height;
            if(wid < image_width || ht < image_height){
              swal({
                    title: "",
                    text: "Height and Width must more than 485x325.",

                }, function () {
                  $("#preview_image").attr("src","")

                })
                return false;
            }

        };

        img.src = _URL.createObjectURL(file);
    }

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
