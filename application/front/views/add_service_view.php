<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
  .active div{
    color: #299494;
  }
  .left{
    float: left;
  }
  .right{
    float: right;
  }
  .worker-image{
    width: 150px;
    height: auto;
    border: 2px solid #f2f2f2;
    margin: 10px;
  }
  .fa-minus-circle{
    color:#FF0000;
  }
  .back_btn{
    float: right;
    text-decoration: underline;
    font-weight: bold;
  }
  .cls-time-input{
    width: 33% !important;
    float: left !important;
    margin-right: 10% !important;
  }
</style>
 <form enctype="multipart/form-data" method="post"  id="add_service" name="add_service" data-toggle="validator" action="<?php echo site_url("shop/insert_shop/"); ?>">
<section class="block bg_white">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12">
    	   <div class="multistepform">
    	   <span class="form-title">ADD SHOP</span>
         <span class="form-title" style="font-size:14px;"><a href="<?=DOMAIN_URL?>">Home</a> > <a href="<?=DOMAIN_URL?>shop">Shop</a> > Add Shop</span>
    			<div class="container">
  					<main>
            <!-- <a href="http://localhost/ggg/service" class="back_btn"><span><< Go back</span></a> -->
    			  <input id="tab1" type="radio" name="tabs" checked>
    			  <label for="tab1">ADD SHOP INFO</label>

    			  <!-- <input id="tab2" type="radio" name="tabs">
    			  <label for="tab2">SERVICE TYPE</label>

    			  <input id="tab3" type="radio" name="tabs">
    			  <label for="tab3">SELECT BUSINESS HOURS</label>

            <input id="tab4" type="radio" name="tabs">
    			  <label for="tab4">ADD SERVICES</label> -->


             

            <input id="tab2" type="radio" name="tabs">
            <label for="tab2">SELECT BUSINESS HOURS</label>

            <input id="tab3" type="radio" name="tabs">
            <label for="tab3">ADD SERVICES</label>

            <input id="tab4" type="radio" name="tabs">
            <label for="tab4">SERVICE TYPE</label>


    			 <!--  <input id="tab5" type="radio" name="tabs">
    			  <label for="tab5">SELECT WORKER</label> -->
              <br>
             
      			  <section id="content1">
               
                  <input type="hidden" name="categories[]" id="categories">

                  
                  <input type="hidden" name="price[]" id="price">
                  <input type="hidden" name="duration[]" id="duration">
                  <div class="col-md-12 col-xs-12" style="text-align: center !important;">
        			       <span class="form-title">Add Photo <span class="cls_star">*</span></span>
        			    </div>
                  <div class="image_change">
                      <input type="file" id="imgupload1" name="imgupload1" style="display:none" onchange="readURL(this);"/>
                      <img src="<?=base_url()?>front/images/profile.png" alt="" id="preview_image" title="" class="img-responsive img-circle upload_img" />
                      <a id="OpenImgUpload1"> <img src="<?=base_url()?>front/images/camera.png" alt="" title="" class="img-responsive img-circle camera_upload" /> </a>
                  </div>

                  <p class="imagechangetxt">Change Profile Image</p>
                  <hr class="hr_line">
                  <div class="col-md-12 col-xs-12">
                    <span class="form-title left">Add service multiple photos</span>
                      <button type="button" id="OpenImgUpload" class="buttons shopbutton btn_add btn_image_add">Add</button>
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
                <!-- </form> -->
                <hr class="hr_line">
                <div class="edit-form shop-form">
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
                <div class="col-md-12 col-xs-12">
                  <div class="row">
                    <div class="col-md-4 col-xs-12">
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
                <div class="col-md-6 col-md-offset-1 policy">
                    <button type="button" id="next1" class="buttons shopbutton right">Next</button>
                </div>
              </div>
      			</section>
      			
      		 <section id="content2">
             <div class="edit-form shop-form">
               <div class="col-md-12 col-xs-12"  style="text-align: center !important;">
                    <span class="form-title">Select Business Hours<span class="cls_star">*</span></span>
                 </div>
             		<div class="col-md-12 col-md-offset-2" style="height: 50px;">
                 	<div class="col-md-3 bis_hours">
                 		<input type="checkbox" name="" id="gift_chkbx1" checked="checked" class="css-checkbox"><label for="gift_chkbx1" class="css-label css-label-check dayCB">Monday</label>
                 	</div>
                    <div id="datepairExample1" style="float:left;">
                      <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="Monday1" name="Monday1" value="9:00 AM">
                      <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="Monday2" name="Monday2" value="5:00 PM">
                 	  </div>
                  </p>
             		</div>
             		<div class="col-md-12 col-md-offset-2" style="height: 50px;">
                 	<div class="col-md-3 bis_hours">
                 		<input type="checkbox" name="" id="gift_chkbx2" checked="checked" class="css-checkbox"><label for="gift_chkbx2" class="css-label css-label-check dayCB">Tuesday</label>
                 	</div>
                  <div id="datepairExample1" style="float:left;">
                    <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="tuesday1" name="tuesday1" value="9:00 AM">
                    <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="tuesday2" name="tuesday2" value="5:00 PM">
                  </div>
             		</div>
             		<div class="col-md-12 col-md-offset-2" style="height: 50px;">
                 	<div class="col-md-3 bis_hours">
                 		<input type="checkbox" name="" id="gift_chkbx3" checked="checked" class="css-checkbox"><label for="gift_chkbx3" class="css-label css-label-check dayCB">Wednesday</label>
                 	</div>
                  <div id="datepairExample1" style="float:left;">
                    <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="wednesday1" name="wednesday1" value="9:00 AM">
                    <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="wednesday2" name="wednesday2" value="5:00 PM">
                  </div>
             		</div>
             		<div class="col-md-12 col-md-offset-2" style="height: 50px;">
                 	<div class="col-md-3 bis_hours">
                 		<input type="checkbox" name="" id="gift_chkbx4" checked="checked" class="css-checkbox"><label for="gift_chkbx4" class="css-label css-label-check dayCB">Thursday</label>
           		    </div>
                  <div id="datepairExample1" style="float:left;">
                    <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="thursday1" name="thursday1" value="9:00 AM">
                    <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="thursday2" name="thursday2" value="5:00 PM">
                  </div>
             		</div>
             		<div class="col-md-12 col-md-offset-2" style="height: 50px;">
                 	<div class="col-md-3 bis_hours">
                 		<input type="checkbox" name="" id="gift_chkbx5" checked="checked" class="css-checkbox"><label for="gift_chkbx5" class="css-label css-label-check dayCB">Friday</label>
             	   	</div>
                  <div id="datepairExample1" style="float:left;">
                    <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="friday1" name="friday1" value="9:00 AM">
                    <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="friday2" name="friday2" value="5:00 PM">
                  </div>
             		</div>
             		<div class="col-md-12 col-md-offset-2" style="height: 50px;">
                 		<div class="col-md-3 bis_hours">
                 		<input type="checkbox" name="" id="gift_chkbx6" class="css-checkbox"><label for="gift_chkbx6" class="css-label css-label-check dayCB">Saturday</label>
             		 		</div>
                    <div id="datepairExample1" style="float:left;">
                      <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="saturday1" name="saturday1" style="display:none;">
                      <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="saturday2" name="saturday2" style="display:none;">
                    </div>
             		</div>
             		<div class="col-md-12 col-md-offset-2" style="height: 50px;">
                 		<div class="col-md-3 bis_hours">
                 		<input type="checkbox" name="" id="gift_chkbx7" class="css-checkbox"><label for="gift_chkbx7" class="css-label css-label-check dayCB">Sunday</label>
             		 		</div>
                    <div id="datepairExample1" style="float:left;">
                      <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="sunday1" name="sunday1" style="display:none;">
                      <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="sunday2" name="sunday2" style="display:none;">
                    </div>
             		</div>
               <div class="col-md-8 col-md-offset-1 policy" style="margin-left: 13%">
                        <button type="button" id="prev1" class="buttons shopbutton left">Prev</button>
                        <button type="button" id="next2" class="buttons shopbutton right">Next</button>
                    </div>
              </div>
    			 </section>
      		 <section id="content3">
             <div class="edit-form shop-form">
               <div class="col-md-12 col-xs-12"  style="text-align: center !important;">
                  <span class="form-title">Add Your Services <span class="cls_star">*</span></span>
               </div>
               <div class="col-md-12" style="padding-bottom: 12px;">
                 <div class="example">
                     <input type="text" placeholder="Search Services" name="search_services" id="search_services">
                     <button type="button"><i class="fa fa-search"></i></button>
                 </div>
               </div>
               <div class="col-md-12">
                 <div class="timing" id="search-content">
                     <br>
                       <div class="list-timing">
                       <ul id="content-slider" class="content-slider tabs">
                         <?php
                           $k = 1;
                           foreach ($main_category as $cat) {
                             // echo "<pre>"; print_r($cat);exit;
                             $categories = extract($main_category);
                             ?>
                             <li>
                               <a href="#tb<?=$cat->category_id?>" data-btn-id="<?=$cat->category_id?>"><div class="timing_date"><?=$cat->cat_name?></div></a>
                             </li>
                             <?php }?>
                       </ul>
                     </div>
                     <?php
                     // echo "<pre>"; print_r($main_category);exit;
                     foreach ($main_category as $cat) {
                       // echo "<pre>"; print_r($cat);exit;
                       ?>
                     <div id='tb<?=$cat->category_id?>' class="sub-cat-div"></div>
                   <?php }?>
               </div>
              <!--  <div class="col-md-8 col-md-offset-1 policy" style="margin-left: 13%">
                   <button type="button" id="prev3" class="buttons shopbutton left">Prev</button>
                   <button type="button" id="next4" class="buttons shopbutton right">Next</button>
               </div> -->
                <div class="col-md-8 col-md-offset-1 policy" style="margin-left: 13%">
                    <button type="button" id="prev2" class="buttons shopbutton left">Prev</button>
                    <button type="button" id="next3" class="buttons shopbutton right">Next</button>
                </div>
              
               
               <!-- <div class="col-md-6 col-md-offset-1 policy" style="margin-left: 13%">
                 <button type="button" id="next1" class="buttons shopbutton">Next</button>
               </div> -->
             </div>
            </div>
      			</section>



            <section id="content4">
              <div class="edit-form shop-form">
               
                 
                    <div class="col-md-12 col-xs-12"  style="text-align: center !important;">
                      
                       
                      <span class="form-title">Service Type    
                        <span class="cls_star">*</span></span>
                    </div>
 
                    <div id="service_new_option">

                    </div>

                  
                   
                    <div class="col-md-10">
                      <button type="button" id="prev3" class="buttons shopbutton left">Prev</button>
                      <button type="submit" id="submitButton" class="buttons shopbutton right">Submit</button>
                    </div>
                 
               <!-- </form> -->
             </div>
            </
            >

          
    	</div>
    </div>
    </div>
  </div>
</section>

 </form>
<script>
   $(document).ready(function() {

   

   

     $('#tab2, #tab3, #tab4, #tab5').click(function() {
        var shopname = $("#shop_name").valid();
        var shopemail = $("#shop_email").valid();
        var mobile_no = $("#mobile_no").valid();
        var address_1 = $("#address_1").valid();
        var city = $("#city").valid();
        var state = $("#state").valid();
        var zipcode = $("#zipcode").valid();
        var desc = $("#discription").valid();
        if(shopname == false || shopemail == false || mobile_no == false || address_1 == false || city == false || state == false || zipcode == false || desc == false){
          $.alert({
              title: 'Alert!',
              content: 'Please fill all the Shop info!',
          });
          $('#tab1').trigger('click');
        }

     });
     $("#add_service").validate({
      rules: {
        shop_name: "required",
        shop_email: {
          required: true,
          email: true
        },
        mobile_no:{
          required: true,
          number: true
        },
        address_1:"required",
        city:"required",
        state:"required",
        zipcode:"required",
        discription:"required",
      },
      messages: {
        shop_name: "Please specify shop name",
        shop_email: {
          required: "Please enter shop email",
          email: "Your email address must be in the format of name@domain.com"
        },
        mobile_no: {
          required: "Please enter mobile number",
          number: "Please enter digits"
        },
        address_1: "Please specify Address",
        city: "Please specify City",
        state: "Please specify State",
        zipcode: "Please specify Zipcode",
        discription: "Please specify Description",
      }
    });
     $("#next1").click(function(){   $('#tab2').trigger('click');  });
     $("#next2").click(function(){   $('#tab3').trigger('click');  });
     $("#next3").click(function(){   $('#tab4').trigger('click');  });
     $("#next4").click(function(){   $('#tab5').trigger('click');  });

     $("#prev1").click(function(){   $('#tab1').trigger('click');  });
     $("#prev2").click(function(){   $('#tab2').trigger('click');  });
     $("#prev3").click(function(){   $('#tab3').trigger('click');  });
     $("#prev4").click(function(){   $('#tab4').trigger('click');  });
     // $("#next1").click({
     $("#content-slider").lightSlider({
            loop:true,
            keyPress:true
        });
        $('#image-gallery').lightSlider({
            gallery:true,
            item:1,
            thumbItem:9,
            slideMargin: 0,
            speed:500,
            auto:true,
            loop:true,
            onSliderLoad: function() {
                $('#image-gallery').removeClass('cS-hidden');
            }
        });

        $('ul.tabs').each(function(){
          // alert("Afd");
          // $('ul.tabs:first-child').click();
          // alert($('ul.tabs:first-child').hasClass("asdf"));
          // $('ul.tabs.li.a:first-child').click();
          $('ul.tabs li a:first-child').trigger('click');
          // alert($('ul.tabs li a:first-child').attr('href'));
          // For each set of tabs, we want to keep track of
          // which tab is active and its associated content
          var $active, $content, $links = $(this).find('a');

          // If the location.hash matches one of the links, use that as the active tab.
          // If no match is found, use the first link as the initial active tab.
          $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
          $active.addClass('active');

          $content = $($active[0].hash);

          // Hide the remaining content
          $links.not($active).each(function () {
            // alert("asdfafd");
            $(this.hash).hide();
          });

          // Bind the click event handler
          $(this).on('click', 'a', function(e){
            // Make the old tab inactive.
            $active.removeClass('active');
            $content.hide();

            // Update the variables with the new link and content
            $active = $(this);
            $content = $(this.hash);

            // Make the tab active.
            $active.addClass('active');
            $content.show();

            // Prevent the anchor's default click action
            e.preventDefault();
          });
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
    window.location.href = '<?php echo base_url();?>service';
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
$(document).ready(function(){
  $('#OpenImgUpload').click(function() { $('#imgupload').trigger('click'); });
  var array = [];
  var test = [];
 $(document).on('change', "#imgupload", function (e) {
  var files = $('#imgupload')[0].files;
  var file = $(".image_delete").attr("data-file");
  // alert(file);
  var shop_id  = $('#shop_id').val();
  var error = '';
  var form_data = new FormData();

  for(var count = 0; count<files.length; count++)
  {
   var name = files[count].name;
   var imageSize = files[count].size;
   var extension = name.split('.').pop().toLowerCase();
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1){
    error += "Please select only gif, png, jpg or jpeg file"
   } else if (imageSize > 2097152) {
     error += "Please select image size less than 2 MB"
   }else {
       if(files[count].name != file)
       {
         if($.inArray(files[count].name, test) == -1)
         {
           array.push(files[count].name);
         }
       }else {
         test.push(files[count].name);
       }
     }
     if(array.length === 0) {
       // array.push('main_test.php');
     }
     console.log(array);
     $("#json_files").val(array);
   // }
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
    var count = $('#count_image').val();
    var file = $(this).attr("data-file");
    var image_id  = $(this).attr('data-image-id');
    var files = $('#imgupload')[0].files;
    var array = [];
    swal({
      title: "Are you sure?",
      text: "You want to delete this image?",
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
          // array.push('main_test.php');
        }
        console.log(array);
        $("#json_files").val(array);
        $('.img_item'+image_id).remove();
        count = count-1;
        $('#count_image').val(count);
      } else {
      }
    });
  });
$(document).ready(function(){
  $("#city").multiselect({
    header: ['checkAll','uncheckAll'],
  });
  jsonObj = [];
  $("#content-slider li").click(function(){
    var subCatSection = null;
    var cat_id = $(this).children().attr('data-btn-id');
    var tabName = $(this).children().find('div').html();
      subCatSection = this.innerHTML;
      // var cat_id = $(this).attr('data-btn-id');
      // $('#main_category').val(cat_id);
      var flag = '1';
      $.ajax({
          url: "<?php echo base_url(); ?>service/get_sub_category/"+flag,
          type: 'post',
          dataType: 'json',
          data: {cat_id:cat_id},
          success: function (data) {
            // subCatSection = this.innerHTML;
            // console.log(data.length);
            // alert(data.category_id);
            $(".sub-cat-div").html('');
            if(data.length <= 0){
              subCatSection += $(".sub-cat-div").append('There is no service added for <strong>'+tabName+'</strong> category.');
            }else{
              // console.log(jsonObj);
              // console.log(data);
              jQuery.each( data, function( i, val ) {

                  var service_name = 'service_name';
                  var faCircle = 'fa-plus-circle';
                // }
                if(jsonObj.length > 0){
                // jQuery.each( jsonObj, function( j, value ) {
                for(var k = 0, max = jsonObj.length; k < max; k++) {
                  var seen = {};
                  // console.log(jsonObj[k].id);
                  // console.log(val.id);

                    if(jsonObj[k].id === val.id){
                      var new_minus_id = val.id;
                        subCatSection += $(".sub-cat-div").append('<div class="col-md-6 service_name_price" ><h4 class="service_name_font">'+val.service_name+'</h4><i class="fas fa-minus-circle add_service" id="'+val.id+'" cat-id="'+cat_id+'" service-name="'+val.service_name+'" price="'+val.price+'" duration="'+val.time+'"></i><div class="service_price">Price: $'+val.price+' Duration: '+val.time+'min</div></div></div>');
                    }
                  }
                }else{
                  // alert("out");
                  subCatSection += $(".sub-cat-div").append('<div class="col-md-6 service_name" ><h4 class="service_name_font">'+val.service_name+'</h4><i class="fas fa-plus-circle add_service" id="'+val.id+'" cat-id="'+cat_id+'" service-name="'+val.service_name+'" price="'+val.price+'" duration="'+val.time+'"></i><div class="service_price">Price: $'+val.price+' Duration: '+val.time+'min</div></div></div>');
                }
              });
              if(jsonObj.length > 0){
                for( var i=data.length - 1; i>=0; i--){
                  for( var j=0; j<jsonObj.length; j++){
                      if(data[i] && (data[i].id === jsonObj[j].id)){
                        data.splice(i, 1);
                      }
                    }
                }
                jQuery.each( data, function( i, val ) {
                  subCatSection += $(".sub-cat-div").append('<div class="col-md-6 service_name" ><h4 class="service_name_font">'+val.service_name+'</h4><i class="fas fa-plus-circle add_service" id="'+val.id+'" cat-id="'+cat_id+'" service-name="'+val.service_name+'" price="'+val.price+'" duration="'+val.time+'"></i><div class="service_price">Price: $'+val.price+' Duration: '+val.time+'min</div></div></div>');
                });
              }
            }
            $(".add_service").click(function(){
                var serviceName = $(this).attr('service-name');
                var price = $(this).attr('price');
                var duration = $(this).attr('duration');
               // console.log(jsonObj);

  						if($(this).parent().hasClass('service_name_price') == true){
  							// alert($(this).parent().hasClass('service_name_price'));
  							$(this).parent().removeClass('service_name_price');
  							$(this).parent().addClass('service_name');

  							$(this).removeClass('fa-minus-circle');
  							$(this).addClass('fa-plus-circle');
  							$(this).css('color', '#000');
                // $(this).attr('id',id);
                // alert($(this).attr("id"));
                for(var i = 0, max = jsonObj.length; i < max; i++) {
                    var a = jsonObj[i];

                    if(a.id === $(this).attr("id")) {
                        jsonObj.splice(i, 1);
                        break;
                    }
                }
  						}else {
  							$(this).parent().removeClass('service_name');
  							$(this).parent().addClass('service_name_price');

  							$(this).removeClass('fa-plus-circle');
  							$(this).addClass('fa-minus-circle');
  							$(this).css('color', '#ff0000');
                if(typeof($(this).attr("id")) != 'undefined'){
                   var id = $(this).attr("id"); 

                  // var lang = [];
                  // lang.push(id);
                  // var datastring = lang;
                  // console.log(datastring);

                  // $.each(data.programs, function (i) {
                  //   $.each(data.programs[i], function (key, val) {
                  //   alert(key + val);
                  //  });
                  // });

                  
                   // var email = $(this).val();
                   item = {}
                   item ["id"] = id;
                   item ["cat_id"] = cat_id;
                   item ["serviceName"] = serviceName;
                   item ["price"] = price;
                   item ["duration"] = duration;
                   // $("#categories").val(item);
                   jsonObj.push(item);
                  //console.log(jsonObj);
                   // console.log(jsonObj.length);
                    var html = '';

                    for (var i = 0; i < jsonObj.length; i++) {
             //    html += '<option value="'+ data1[i].category_id +'">'+ data1[i].cat_name +'</option>';
             // html += '<span>'+ data1[i][0].cat_name +'</span><br>';
           

              html += "  <h3><span>"+ jsonObj[i]['serviceName'] +"</span></h3><div class='col-md-12 bis_hours' style='height: 60px'><input type='radio' name='service_type["+[i]+"]' id='worker_permission["+[i]+"]' value='1' class='css-checkbox'  > <label for='worker_permission["+[i]+"]' class='css-label css-label-check' style='font-size: 16px; font-weight: bold;'>Home</label>                      <span class='radio_policy'>Provider will go to client's home</span>                    </div>                    <div class='col-md-12 bis_hours' style='height: 60px'>                      <input type='radio' name='service_type["+[i]+"]' id='shop_permission["+[i]+"]' value='2' class='css-checkbox' checked>                      <label for='shop_permission["+[i]+"]' class='css-label css-label-check' style='font-size: 16px; font-weight: bold;'>Shop</label>                      <span class='radio_policy'>Client needs to visit shop</span>                    </div>                    <div class='col-md-12 bis_hours' style='height: 60px'>                      <input type='radio' name='service_type["+[i]+"]' id='both_permission["+[i]+"]' value='3' class='css-checkbox'>                      <label for='both_permission["+[i]+"]' class='css-label css-label-check' style='font-size: 16px; font-weight: bold;'>Both</label>                      <span class='radio_policy'>Both Options are available.</span>                    </div>";

              }
              $('#service_new_option').html(html);

                   var hidden_cat = JSON.stringify(jsonObj);
                   $("#categories").val(hidden_cat);

                  

                   
                }
  						}
  					});
          },error: function(data){
              alert("Something went wrong, please try again.");
          }
      });
  });

  // $("#submitButton").click(function(){
  $("#add_service1").submit(function(){
    console.log(jsonObj);
    var inputFile=$('input[name=imgupload1]');
    var fileToUpload=inputFile[0].files[0];
    // console.log(fileToUpload);
    var worker_permission = $("input[name='service_type']:checked").val();
    var shop = $("input[name='radiog_list']:checked").val();
    var radiog_list_worker_time = [];
    $.each($("input[name='radiog_list_worker_time[]']:checked"), function(){
        radiog_list_worker_time.push($(this).val());
    });
    // console.log(radiog_list_worker_time.length);
    // radiog_list_worker_time = $("input[name='radiog_list_worker_time']:checked").val();
    // console.log($('input[name="radiog_list_worker_time"]:checked').serialize());
    if(typeof(jsonObj) === 'undefined' || jsonObj == ''){
      $.alert({
          title: 'Alert!',
          content: 'Please select Category!',
      });
      return false;
    }
    // else if(typeof(shop) === 'undefined'){
    //   $.alert({
    //       title: 'Alert!',
    //       content: 'Please select Shop!',
    //   });
    //   return false;
    // }

    // else if(radiog_list_worker_time == ''){
    //   $.alert({
    //       title: 'Alert!',
    //       content: 'Please select Worker!',
    //   });
    //   return false;
    // }
    
    else{
      // $( "#add_service" ).submit();
      $.ajax({
          url: "<?php echo base_url(); ?>shop/insert_shop/",
          type: 'post',
          dataType: 'json',
          fileElementId	:'imgupload1',
          data: {categories:jsonObj, worker_permission:worker_permission, shop:shop, radiog_list_worker_time:radiog_list_worker_time},
          // data:data,
          success: function (data) {
          }
        });
    }
  });

  $("#gift_chkbx1").click(function () {
      if ($(this).is(":checked")) { $("#Monday1").show(); $("#Monday2").show();
    } else {  $("#Monday1").hide(); $("#Monday2").hide(); $("#Monday1").val(""); $("#Monday2").val("");
    }
  });
  $("#gift_chkbx2").click(function () {
      if ($(this).is(":checked")) { $("#tuesday1").show(); $("#tuesday2").show();
    } else { $("#tuesday1").hide(); $("#tuesday2").hide(); $("#tuesday1").val(""); $("#tuesday2").val("");
      }
  });
  $("#gift_chkbx3").click(function () {
      if ($(this).is(":checked")) { $("#wednesday1").show(); $("#wednesday2").show();
    } else { $("#wednesday1").hide(); $("#wednesday2").hide(); $("#wednesday1").val(""); $("#wednesday2").val("");
      }
  });
  $("#gift_chkbx4").click(function () {
      if ($(this).is(":checked")) { $("#thursday1").show(); $("#thursday2").show();
    } else { $("#thursday1").hide(); $("#thursday2").hide(); $("#thursday1").val(""); $("#thursday2").val("");
      }
  });
  $("#gift_chkbx5").click(function () {
      if ($(this).is(":checked")) { $("#friday1").show(); $("#friday2").show();
    } else { $("#friday1").hide(); $("#friday2").hide();$("#friday1").val(""); $("#friday2").val("");
      }
  });
  $("#gift_chkbx6").click(function () {
      if ($(this).is(":checked")) { $("#saturday1").show(); $("#saturday2").show();
      } else { $("#saturday1").hide(); $("#saturday2").hide(); $("#saturday1").val(""); $("#saturday2").val("");
      }
  });
  $("#gift_chkbx7").click(function () {
      if ($(this).is(":checked")) { $("#sunday1").show(); $("#sunday2").show();
    } else { $("#sunday1").hide(); $("#sunday2").hide(); $("#sunday1").val(""); $("#sunday2").val("");
      }
  });
});
// $(".sub-cat-div").click(function(){
//   // alert($(this).children().hasClass('service_name_price'));
//   if($(this).children().hasClass('service_name_price') == true){
//     alert($(this).find( "i" ).attr("id"));
//     // alert($(this).parent().hasClass('service_name_price'));
//     $(this).children().removeClass('service_name_price');
//     $(this).children().addClass('service_name');
//
//     $(this).find( "i" ).removeClass('fa-minus-circle');
//     $(this).find( "i" ).addClass('fa-plus-circle');
//     $(this).find( "i" ).css('color', '#000');
//   }else {
//     $(this).children().removeClass('service_name');
//     $(this).children().addClass('service_name_price');
//
//     $(this).find( "i" ).removeClass('fa-plus-circle');
//     $(this).find( "i" ).addClass('fa-minus-circle');
//     $(this).find( "i" ).css('color', '#ff0000');
//   }
//   // $(this).parent().addClass('service_name');
// });
</script>
