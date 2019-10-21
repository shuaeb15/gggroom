<?php $this->load->view('templates/_include/header_view1'); ?>

<style media="screen">
.dlt_shop_btn{
    width: 230px !important;
}
.save_shop_btn{
    width: 230px !important;
}
label.css-label-check {
    margin-right: 26px !important;
}
.col-md-6 {
    width: 50% !important;
}
.btn_image_add{
  border-color: rgb(37, 144, 144) !important;
  width: 90px !important;
}
.cls_policy_p{
    margin: 0 !important;
    padding: 0 !important;
}
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
  input[type="checkbox"] {
    position: unset;
    right: 0px;
    width: 16px;
    height: 16px;
}
input[type="radio"]{
  position: unset;
  right: 0px;
  width: 1px;
  height: 1px;
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

@media only screen and (max-width:480px){
  .col-md-6 {
      width: 100% !important;
  }
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

          <form enctype="multipart/form-data" method="post"  id="add_shop" name="add_shop" data-toggle="validator" action="<?php echo site_url("shop/insert_shop/"); ?>">
            <div class="col-xs-12 col-sm-12 col-md-12 css_title" style="text-align: center;">
                <span class="form-title" style="float:none;font-size: 25px;margin: 0 auto 30px auto;">Add shop</span>
            </div>
            <div class="image_change">
                <input type="file" id="imgupload1" name="imgupload1" style="display:none" onchange="readURL(this);"/>
                <img src="<?=base_url()?>front/images/banner.jpg" alt="" id="preview_image" title="" class="img-responsive img-circle upload_img" />
                <a id="OpenImgUpload1"> <img src="<?=base_url()?>front/images/camera.png" alt="" title="" class="img-responsive img-circle camera_upload" /> </a>
            </div>
            <p class="imagechangetxt">Change Profile Image</p>
            <hr class="hr_line">
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Shop multiple photos</span>
                <button type="button" id="OpenImgUpload" class="btn-success btn_border btn_add btn_image_add">Add</button>
            </div>

            <div class="image_change">
              <input type="file" name="files[]" id="imgupload" multiple style="display:none"/>
              <input type="hidden" name="json_files" id="json_files" />
              <input type="hidden" name="count_image" id="count_image" value="0">
            </div>
            <div class="col-md-12 col-xs-12 image_preview">
              <div class="row" id="uploaded_images">

                </div>
              </div>
              <hr class="hr_line">

            <div class="col-md-12 col-xs-12">
              <span class="form-title">Shop Info</span>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="fname">Shop Name <span class="cls_star">*</span></label>
                <input type="text" class="form-control" name="shop_name" id="shop_name">
              </div>
            </div>
            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="lname">Shop Email <span class="cls_star">*</span></label>
                <input type="email" class="form-control" name="shop_email" id="shop_email">
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="uname">Phone No <span class="cls_star">*</span></label>
                <input type="text" class="form-control" name="mobile_no" id="mobile_no">
              </div>
            </div>
            <!-- <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="email">Title <span class="cls_star">*</span></label>
                <input type="text" class="form-control" name="shop_title" id="shop_title">
              </div>
            </div> -->
            <div class="col-md-12 col-xs-12 cls_addline">
              <div class="form-group">
                <label for="pwd">Address Line 1 <span class="cls_star">*</span></label>
                <input type="text" class="form-control" name="address_1" id="address_1">
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="cpwd">Address Line 2</label>
                <input type="text" class="form-control" name="address_2" id="address_2">
              </div>
            </div>
            <!-- <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="uname">City <span class="cls_star">*</span></label><br>
                <select class="city form-control" id="city" name="city" multiple>
                  <?php foreach ($city as $val) {?>
                    <option value="<?=$val->id?>"><?=$val->name?></option>
                    <?php }?>
                </select>
                <input type="text" class="form-control" name="city" id="city">
              </div>
            </div> -->
            <div class="col-md-12 col-xs-12">
              <div class="row">
                <div class="col-md-4 col-xs-12" style="width: 29% !important;">
                  <div class="form-group">
                    <label for="uname">City <span class="cls_star">*</span></label><br>
                    <select class="city form-control" id="city" name="city[]" multiple="multiple">
                      <?php foreach ($city as $val) {?>
                        <option value="<?=$val->id?>"><?=$val->name?></option>
                        <?php }?>
                    </select>
                    <!-- <input type="text" class="form-control" name="city" id="city"> -->
                  </div>
                </div>
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="email">State <span class="cls_star">*</span></label>
                    <select class="form-control" name="state" id="state">
                      <option value="">--Select--</option>
                      <?php foreach ($state as $val) {?>
                        <option value="<?=$val->id?>"><?=$val->name?></option>
                        <?php }?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="">Zip code <span class="cls_star">*</span></label>
                    <input type="text" class="form-control" name="zipcode" id="zipcode">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="form-group">
                <label for="">Description <span class="cls_star">*</span></label>
                <textarea rows="8" class="form-control" name="discription" id="discription" placeholder="Please add a description"></textarea>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="hr_line">
            </div>
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Cancelletion Policy <span class="cls_star">*</span></span>
            </div>
            <div class="col-md-12 col-xs-12">
              <div class="row radio_policy">
                <div class="col-md-4 col-xs-12">
                  <input type="radio" name="radiog_dark" id="radio4" class="css-checkbox" checked value="1"/>
                  <label for="radio4" class="css-label css-label-check radGroup1 radGroup2"><p class="cls_policy_p">Strict</p>
                    <span>No cancellation</span>
                  </label>
                </div>
                <div class="col-md-4 col-xs-12">
                  <input type="radio" name="radiog_dark" id="radio5" class="css-checkbox" value="2" />
                  <label for="radio5" class="css-label css-label-check radGroup1 radGroup2"><p class="cls_policy_p">Moderate</p>
                    <span>Cancellation before 48 hours</span>
                  </label>
                </div>
                <div class="col-md-4 col-xs-12">
                  <input type="radio" name="radiog_dark" id="radio6" class="css-checkbox" value="3" />
                  <label for="radio6" class="css-label css-label-check radGroup1 radGroup2"><p class="cls_policy_p">Flexible</p>
                    <span>Anytime cancellation</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-xs-12 cls_business_hours">
              <hr class="hr_line">
            </div>
            <div class="col-md-12 col-xs-12">
              <span class="form-title">Business Hours <span class="cls_star">*</span></span>
                <a href="javascript:void(0)" class="btn_add btn_add_img" onclick="changeDisplay();">
                  <img src="<?=base_url()?>front/images/delete.png" class="btn_add img_business">
                </a>
            </div>
            <div class="item form-group " id="cls-day-time">
              <div class="col-xs-12 cls-chk">
                <p id="datepairExample1">
                <input type="text" class="date start hide">
                <label class="cl_lbl_time">Start Time</label>
                <input type="text" class="time start ui-timepicker-input cls-time-input" id="Monday1" name="Monday1">
                <label class="cl_lbl_end_time">End Time</label>
                <input type="text" class="time end ui-timepicker-input cls-time-input" id="Monday2" name="Monday2">
                <input type="text" class="date end hide">
                  </p>
              </div>
              <!-- <div class="col-md-12 col-xs-12">
                <span class="form-title">Breaks</span>
              </div>
              <div class="item form-group " id="cls-breaks-time">
                <div class="col-xs-12 cls-chk">
                  <p id="datepairExample_breaks1">
                  <input type="text" class="date start hide">
                  <label style="width: 12%;font-size:21px;">Start Time</label>
                  <input type="text" class="time start ui-timepicker-input cls-time-input" id="break_Monday1" name="break_Monday1" style="margin-bottom:10px;font-size: 20px;">
                  <label style="width: 12%;font-size:21px;margin-left:70px;">End Time</label>
                  <input type="text" class="time end ui-timepicker-input cls-time-input" id="break_Monday2" name="break_Monday2" style="margin-bottom:10px;font-size: 20px;">
                  <input type="text" class="date end hide">
                    </p>
                </div>
              </div> -->
              <div class="col-xs-2 cls-chk cls_radio_btn" style="border-right: 1px solid lightgrey;">
                <input type="radio" name="radio_day" id="radio7" class="css-checkbox radio_day" onclick="ChangeWorkingDay('1');" checked value="1"/>
                <label for="radio7" class="css-label css-label-check radGroup1 radGroup2">
                  <span>Daily</span>
                </label>
                <input type="radio" name="radio_day" id="radio8" class="css-checkbox radio_day" onclick="ChangeWorkingDay('2');" value="2"/>
                <label for="radio8" class="css-label css-label-check radGroup1 radGroup2">
                  <span>Weekly</span>
                </label>
                <!-- <input type="radio" name="radio_day" id="radio9" class="css-checkbox radio_day" onclick="ChangeWorkingDay('3');" value="3"/>
                <label for="radio9" class="css-label css-label-check radGroup1 radGroup2">
                  <span>Monthly</span>
                </label>
                <input type="radio" name="radio_day" id="radio10" class="css-checkbox radio_day" onclick="ChangeWorkingDay('4');" value="4"/>
                <label for="radio10" class="css-label css-label-check radGroup1 radGroup2">
                  <span>Yearly</span>
                </label> -->
              </div>
              <div class="col-xs-10 cls-chk cls_day">
                  <input type="checkbox" name="service_time[]" id="service_day1" class="css-checkbox cls_all_service" value="Monday" checked>
                  <label for="service_day1" class="css-label css-label-check dayCB">Monday</label>
                  <input type="checkbox" name="service_time[]" id="service_day2" class="css-checkbox cls_all_service" value="Tuesday" checked>
                  <label for="service_day2" class="css-label css-label-check dayCB">Tuesday</label>
                  <input type="checkbox" name="service_time[]" id="service_day3" class="css-checkbox cls_all_service" value="Wednesday" checked>
                  <label for="service_day3" class="css-label css-label-check dayCB">Wednesday</label>
                  <input type="checkbox" name="service_time[]" id="service_day4" class="css-checkbox cls_all_service" value="Thursday" checked>
                  <label for="service_day4" class="css-label css-label-check dayCB">Thurday</label>
                  <input type="checkbox" name="service_time[]" id="service_day5" class="css-checkbox cls_all_service" value="Friday" checked>
                  <label for="service_day5" class="css-label css-label-check dayCB">Friday</label>
                  <input type="checkbox" name="service_time[]" id="service_day6" class="css-checkbox cls_all_service" value="Saturday" checked>
                  <label for="service_day6" class="css-label css-label-check dayCB">Saturday</label>
                  <input type="checkbox" name="service_time[]" id="service_day7" class="css-checkbox cls_all_service" value="Sunday" checked>
                  <label for="service_day7" class="css-label css-label-check">Sunday</label>
              </div>
            </div>
            <div class="col-md-12 col-xs-12 cls_breaks">
              <hr class="hr_line margin_bottom_30">
            </div>
            <div class="col-md-12 center_btn_main">
              <div class="center_btn_sub">
                <div class="center_btn_subitem">
                  <button type="button" class="dlt_shop_btn" id="btn-submit">Cancel</button>
                </div>
                <div class="center_btn_subitem">
                  <button type="submit" class="save_shop_btn">Add Shop</button>
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
$(document).ready(function(){
  $("#city").multiselect({
    header: ['checkAll','uncheckAll'],
  });
});
</script>
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
          $('#btn-submit').click(function() {
            window.location.href = '<?php echo base_url();?>shop';
          });

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
$(document).ready(function(){
  $('#OpenImgUpload').click(function() { $('#imgupload').trigger('click'); });

 $(document).on('change', "#imgupload", function (e) {
  var files = $('#imgupload')[0].files;
  // console.log(files);
  var shop_id  = $('#shop_id').val();
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
	   var storedFiles = [];

     var files = e.target.files;
		 var filesArr = Array.prototype.slice.call(files);

     var count = $('#count_image').val();
		 filesArr.forEach(function(f) {

			if(!f.type.match("image.*")) {
				return;
			}
			storedFiles.push(f);

			var reader = new FileReader();
      var delete_image = "<?php echo base_url()?>front/images/close.png"

			reader.onload = function (e) {

				var html = "<div class=\"col-md-4 col-xs-12 image_preview_item img_item" + count + "\"><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='img-responsive'><img class=\"close image_delete\" data-file='"+f.name+"' data-image-id='"+count+"' src=\"" + delete_image + "\" /></div>";
				$('#uploaded_images').append(html);
        count ++;
        $('#count_image').val(count);
			}
			reader.readAsDataURL(f);
		});
  }
 });

});


</script>


<script type="text/javascript">
  var test = [];
  $(document).on('click', ".image_delete", function (e) {
    var file = $(this).attr("data-file");
    var image_id  = $(this).attr('data-image-id');
    var files = $('#imgupload')[0].files;
    var array = [];
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
        var form_data = new FormData();
        for(var i=0; i<files.length; i++)
        {
          if(files[i].name != file)
          {
            if($.inArray(files[i].name, test) == -1)
            {
              array.push(files[i].name);
            }
          }
          else {
            test.push(files[i].name);
          }
        }
        if(array.length === 0) {
          array.push('main_test.php');
        }
        $("#json_files").val(array);
          $('.img_item'+image_id).remove();

      } else {
      }
    });
  });
</script>

<script type="text/javascript">
function changeDisplay() {
var x = document.getElementById("cls-day-time");

if (x.style.display === "none") {
x.style.display = "block";
$('.img_business').attr('src','<?php echo base_url(); ?>front/images/delete.png');
} else {
x.style.display = "none";
$('.img_business').attr('src','<?php echo base_url(); ?>front/images/add.png');
}
}

function ChangeWorkingDay(argument) {
  if(argument == '1')
  {
    $("#service_day1").prop("checked", true);
    $("#service_day2").prop("checked", true);
    $("#service_day3").prop("checked", true);
    $("#service_day4").prop("checked", true);
    $("#service_day5").prop("checked", true);
    $("#service_day6").prop("checked", true);
    $("#service_day7").prop("checked", true);
  }
  if(argument == '2')
  {
    $("#service_day1").prop("checked", true);
    $("#service_day2").prop("checked", true);
    $("#service_day3").prop("checked", true);
    $("#service_day4").prop("checked", true);
    $("#service_day5").prop("checked", true);
    $("#service_day6").prop("checked", false);
    $("#service_day7").prop("checked", false);
  }
  if(argument == '3')
  {
    $("#service_day1").prop("checked", false);
    $("#service_day2").prop("checked", false);
    $("#service_day3").prop("checked", false);
    $("#service_day4").prop("checked", false);
    $("#service_day5").prop("checked", false);
    $("#service_day6").prop("checked", false);
    $("#service_day7").prop("checked", false);
  }
  if(argument == '4')
  {
    $("#service_day1").prop("checked", false);
    $("#service_day2").prop("checked", false);
    $("#service_day3").prop("checked", false);
    $("#service_day4").prop("checked", false);
    $("#service_day5").prop("checked", false);
    $("#service_day6").prop("checked", false);
    $("#service_day7").prop("checked", false);
  }
}
</script>
