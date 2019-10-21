<?php $this->load->view('templates/_include/header_view1'); ?>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<script src="<?php echo base_url('front/js/jFormslider.js');?>"></script>
<style media="screen">
.top_head h3{
      margin-top: -16px !important;
}
.cls_profile_image{
    width: auto;
    height: 100%;
    background-size: cover;
}
.left_sec_profile{
  padding-right: 0px !important;
}
#demo-modal{
  padding: 5px 20px;
}
@media only screen and (max-width:480px){
  .cls_profile_image{
      height: auto !important;
  }
  .top_head h3{
      margin-top: 20px !important;
  }
  .right_sec_profile{
    width: 100% !important;
    margin-top: 20px !important;
  }
  .profile_sec .bottom_sec p{
    float: left !important;
    margin: 0 10px !important;
    font-size: 16px !important;
    line-height: 1em !important
  }
  .profile_sec .bottom_sec h3{
    float: left !important;
  }
  .cls_appointment_view{
    margin: 5px 0 0 0 !important;
  }
}
</style>
<script type="text/javascript">
  $( document ).ready(function() {
    var poll_submit = '<?=$userlist->poll_submit?>';
      var options = {
    			modal: true,
    			height:300,
    			width:500
  		};
      var optionsSlider = {
        width:560,//width of slider
        height:500,//height of slider
        next_prev:true,//will show next and prev links
        next_class:'btn btn-primary',//class for next link
        prev_class:'btn btn-primary',//class for prev link
        error_class:'alert alert-danger',//class for validation errors
        texts:{
            next:'next',//verbiage for next link
            prev:'back'//verbiage for prev link
        },
        speed:600,//slider speed

      };
    	$('#demo-modal').load('<?php echo base_url(); ?>Profile/get_poll_data?modal=test',
      function(data) {
        if(poll_submit == '0'){
  		    $('#bootstrap-modal').modal({show:true});
        	$('#slider').jFormslider(optionsSlider);
        }
          // data = JSON.parse(data);
          // console.log(data);
          // $.each( data, function(key, value) {
          // });
      });

      // var options=
    	// {
    	// 	width:530,//width of slider
    	// 	height:500,//height of slider
    	// 	next_prev:true,//will show next and prev links
    	// 	next_class:'btn btn-primary btn-xs',//class for next link
    	// 	prev_class:'btn btn-primary btn-xs',//class for prev link
    	// 	error_class:'alert alert-danger',//class for validation errors
    	// 	texts:{
    	// 			next:'next',//verbiage for next link
    	// 			prev:'back'//verbiage for prev link
    	// 		  },
    	// 	speed:600,//slider speed
    	// };
    	// $('#slider').jFormslider(options);
  });
  function last_slide()
  {
    // alert("you are going to reach last slide if this function retuned true");
    return true;
  }
</script>
<div class="modal fade" id="bootstrap-modal" role="dialog">
  <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Bootstrap Dynamic Modal Content</h4>
          </div>
          <div id="demo-modal">
          </div>
      <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>
<section class="block">
  <div class="container">
    <!--slider starts-->
    <!-- <div id="slider" class="form">
    <ul>
        <li data-id="slider_start">
            <div class="form-group">
                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                <input type="text" id="em1" class="form-control" data-toggle="tooltip" data-placement="top" title="Enter valid email" placeholder="Enter email" email>
            </div>
            <div class="form-group">
                <label class="sr-only" for="exampleInputEmail2">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail2" placeholder="Enter Name" required>
            </div>
            <button type="button" class="btn btn-info" onclick="$('#slider').gotoSlide('slider_end')">Click here to go to last slide</button>
        </li>
        <li>
            <div class="form-group">
                <label for="exampleInputFile" class="sr-only">File input</label>
                <input type="file" id="exampleInputFile" required data-msg="Please upload">
            </div>
            <div class="form-group">
                <label for="exampleInputFile" class="sr-only">File input</label>
                <select required>
                    <option value="">ggg</option>
                    <option value="dsfd">hg</option>
                    <option value="dsfd">hghg</option>
                </select>
            </div>
        </li>
        <li data-id="slider_end" call-before="last_slide()">
            <div class="alert alert-success">
                slider ends
            </div>
            <button type="button" class="btn btn-info" onclick="$('#slider').gotoSlide('slider_start')" style="margin-bottom: 10px;">Click here to go to First slide</button>
        </li>
    </ul>
    </div> -->
		<!--slider ends-->
  </div>
</section>
<section class="block">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12">
        <div class="row profile_sec center">
        <?php if($this->session->flashdata('error_message')){?>
                <div class="alert alert-danger alert-dismissable">
                  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                  <?php echo $this->session->flashdata('error_message'); ?>
                </div>
        <?php }?>
        <?php if ($this->session->flashdata('success_message')) { ?>
                <div class="alert alert-success alert-dismissable">
                  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                  <?php echo $this->session->flashdata('success_message'); ?>
                </div>
        <?php }?>
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
        <div class="col-md-6 left_sec_profile">
            <img src="<?=$main_image?>" class="img-responsive cls_profile_image">
            <div class="editimg">
              <a href="profile/edit_profile/<?=$userlist->encrypt_id;?>"><img src="<?=base_url()?>front/images/plus.png"></a>
            </div>
        </div>
        <div class="col-md-6 right_sec_profile">
          <div class="editbtn">
            <a href="profile/edit_profile/<?=$userlist->encrypt_id;?>"><img src="<?=base_url()?>front/images/pencil.png"></a>
          </div>
          <div class="col-md-12 padding_0 top_head">
            <h3><?=$userlist->firstname;?> <?=$userlist->lastname;?></h3>
            <p style="margin-top:-10px;padding-top: 0px;">@<?=$userlist->username;?></p>
          </div>
          <div class="col-md-12 padding_0 middle_sec">
            <ul>
              <?php if($userlist->address1 != ''){?>
                      <li class="location">
                        <img src="<?=base_url()?>front/images/location.png">
                        <span>
                          <?=$userlist->address1;?><?php if($userlist->address2 != ''){ echo ',';}?> <?=$userlist->address2;?><?php if($userlist->city_name != ''){ echo ',';}?> <?=$userlist->city_name;?><?php if($userlist->state_name != ''){ echo ',';}?> <?=$userlist->state_name;?><?php if($userlist->zipcode != ''){ echo ',';}?> <?=$userlist->zipcode;?>
                        </span>
                      </li>
              <?php }?>
              <?php if($userlist->email != ''){?>
                      <li>
                        <img src="<?=base_url()?>front/images/env.png"> <span><?=$userlist->email;?></span>
                      </li>
              <?php }?>
              <?php if($userlist->mobile != ''){?>
                      <li>
                        <img src="<?=base_url()?>front/images/mob.png"> <span><?=$userlist->mobile;?></span>
                      </li>
              <?php }?>
            </ul>
          </div>
          <div class="col-md-12 padding_0 bottom_sec" style="margin-top: -14px;">
            <div class="col-md-4 col-xs-12 cls_appointment_view">
                <h3 style="margin-top:0px;margin-bottom:0px;">Appointments</h3>
                <p style="padding-top: 0px;"><?php echo $appointmentCount; ?></p>
            </div>
            <div class="col-md-4 col-xs-12 cls_favorite_view">
                <h3 style="margin-top:0px;margin-bottom:0px;">Favorites</h3>
                <p style="padding-top: 0px;"><?php echo $favCount; ?></p>
            </div>
          </div>
         </div>
        </div>
      </div>
      <?php if($userlist->u_category == '2' || $userlist->u_category == '3'){?>
             <div class="col-xs-12 col-sm-12">
               <div class="flex_box">
                 <div class='photo-grid-container'>
                   <div class='photo-grid container'>
                     <!-- <div class='photo-grid-item'>
                       <a href="<?php echo site_url();?>shop" title="">
                       <div class="photo-grid-item_inner">
                         <img src='<?=base_url()?>front/images/shop.png'/>
                         <h3>Shops</h3>
                       </div>
                       </a>
                    </div> -->
                    <div class='photo-grid-item'>
                      <a href="<?php echo site_url();?>worker" title="">
                        <div class="photo-grid-item_inner">
                          <img src='<?=base_url()?>front/images/worker.png'/>
                          <h3>Workers</h3>
                        </div>
                      </a>
                    </div>
                    <div class='photo-grid-item'>
                      <a href="<?php echo site_url();?>shop" title="">
                      <div class="photo-grid-item_inner">
                        <img src='<?=base_url()?>front/images/services.png'/>
                        <h3>Shops and Services</h3>
                      </div>
                      </a>
                    </div>
                    <div class='photo-grid-item'>
                      <a href="<?php echo base_url('setting'); ?>" title="">
                      <div class="photo-grid-item_inner">
                        <img src='<?=base_url()?>front/images/settings.png'/>
                        <h3>Settings</h3>
                      </div>
                      </a>
                    </div>
                    <div class='photo-grid-item'>
                      <a href="<?php echo base_url('calendar'); ?>" title="">
                      <div class="photo-grid-item_inner">
                        <img src='<?=base_url()?>front/images/business_cal.png'/>
                        <h3>Business Calendar</h3>
                      </div>
                      </a>
                    </div>
                    <div class='photo-grid-item'>
                      <a href="<?php echo base_url('category'); ?>" title="">
                      <div class="photo-grid-item_inner">
                        <img src='<?=base_url()?>front/images/services.png'/>
                        <h3>Add Service Title</h3>
                      </div>
                      </a>
                    </div>
                    <div class='photo-grid-item'>
                      <a href="<?php echo base_url('offers'); ?>" title="">
                      <div class="photo-grid-item_inner">
                        <img src='<?=base_url()?>front/images/services.png'/>
                        <h3>Add Offers</h3>
                      </div>
                      </a>
                    </div>
                    <div class='photo-grid-item'>
                      <a href="<?php echo base_url('document'); ?>" title="">
                      <div class="photo-grid-item_inner">
                        <img src='<?=base_url()?>front/images/services.png'/>
                        <h3>Add Documents</h3>
                      </div>
                      </a>
                    </div>
                    <div class='photo-grid-item'>
                      <a href="<?php echo base_url('feedback'); ?>" title="">
                      <div class="photo-grid-item_inner">
                        <img src='<?=base_url()?>front/images/services.png'/>
                        <h3>Feedback</h3>
                      </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php }else{?>
            <div class="col-xs-12 col-sm-12">
              <div class="flex_box">
                <div class='photo-grid-container'>
                  <!-- <div class='photo-grid container'> -->
                    <div class='photo-grid-item'>
                      <a href="<?php echo base_url('setting'); ?>" title="">
                      <div class="photo-grid-item_inner">
                        <img src='<?=base_url()?>front/images/settings.png'/>
                        <h3>Settings</h3>
                      </div>
                      </a>
                    </div>
                   <div class='photo-grid-item'>
                     <a href="<?php echo base_url('feedback'); ?>" title="">
                     <div class="photo-grid-item_inner">
                       <img src='<?=base_url()?>front/images/services.png'/>
                       <h3>Feedback</h3>
                     </div>
                     </a>
                   </div>
                 <!-- </div> -->
               </div>
             </div>
           </div>
          <?php }?>
        </div>
    </div>
</section>
