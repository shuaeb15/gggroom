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
  .css-label{
    padding-top: 10px !important;
  }
</style>
<section class="block bg_white">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12">
         <div class="multistepform">
         <span class="form-title">ADD WORKER</span>
         <span class="form-title" style="font-size:14px;"><a href="<?=DOMAIN_URL?>">Home</a> > <a href="<?=DOMAIN_URL?>worker">Worker</a> > Add Worker</span>
          <form enctype="multipart/form-data" method="post"  id="add_worker" name="add_worker" data-toggle="validator" action="<?php echo site_url("worker/insert_worker"); ?>">
          <div class="container">
            <main>
            <!-- <a href="http://localhost/ggg/service" class="back_btn"><span><< Go back</span></a> -->
            <input id="tab1" type="radio" name="tabs" checked>
            <label for="tab1">WORKER INFO</label>

            <input id="tab2" type="radio" name="tabs">
            <label for="tab2">SELECT SHOP</label>

           

            <input id="tab3" type="radio" name="tabs">
            <label for="tab3"> BUSINESS HOURS</label>

            <input id="tab4" type="radio" name="tabs">
            <label for="tab4">BREAK TIMES</label>

            <input id="tab5" type="radio" name="tabs">
            <label for="tab5">VACATION</label>

             <input id="tab6" type="radio" name="tabs">
            <label for="tab6"> SERVICE</label>
              <br>
              <section id="content1">
                <form   id="add_worker" name="add_worker" data-toggle="validator">
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
                <div class="edit-form shop-form">
                  <div class="col-md-12 col-xs-12"  style="text-align: center !important;">
                    <span class="form-title">Add Worker Information <span class="cls_star">*</span></span>
                  </div>
                  <input type="hidden" name="worker_id" id="worker_id" value="<?=$workerlist->id?>"/>
                  <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                      <label for="fname">Worker Name <span class="cls_star">*</span></label>
                      <input type="text" class="form-control no-border cls-worker-info" Placeholder="Worker Name *" name="worker_name" id="worker_name" value="asfs">
                    </div>
                  </div>
                  <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                      <label for="fname">Worker Email <span class="cls_star">*</span></label>
                      <input type="email" class="form-control cls-worker-info"  Placeholder="Worker Email *" name="worker_email" id="worker_email" value="">
                    </div>
                  </div>
                  <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                      <label for="fname">Worker Mobile No <span class="cls_star">*</span></label>
                      <input type="text" class="form-control cls-worker-info"  Placeholder="Mobile No *"  name="worker_mobile" id="worker_mobile" value="">
                    </div>
                  </div>
                  <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                      <label for="fname">Workers Percentage <span class="cls_star">*</span></label>
                      <input type="number" min="0" class="form-control cls-worker-info"  Placeholder="Percentage" name="worker_percentage" id="worker_percentage" value="">
                    </div>
                  </div>
                  <div class="col-md-6 col-md-offset-1 policy">
                      <button type="button" id="next1" class="buttons shopbutton right">Next</button>
                  </div>
              </div>
            </section>
            <section id="content2">
              <div class="edit-form shop-form">
                <div class="col-md-12 col-xs-12">
                    <span class="form-title">Select Shop <span class="cls_star">*</span></span>
                </div>
                <?php
                $i = 7;
                foreach ($shoplist as $key => $shop) {
                  $i++;?>
                  <div class="col-md-12 col-xs-12 margin_bottom_30">
                    <div class="business_hrs">
                      <div class="col-md-12 col-xs-12">
                        <div class="col-md-11 col-xs-18 business_hrs_inner">
                          <span><?=$shop->shop_name?> </br> <span style="font-size: 16px; color: rgba(0, 0, 0, 0.502);"> <?=$shop->addline1?><?php if($shop->addline2 != ''){ echo ', ';}?><?=$shop->addline2?><?php if($shop->city_name != ''){ echo ', ';}?><?=$shop->city_name?><?php if($shop->state_name != ''){ echo ', ';}?><?=$shop->state_name?><?php if($shop->zipcode != ''){ echo ', ';}?><?=$shop->zipcode?> </span> </span>
                        </div>
                        <input type="hidden" name="shop_id" id="shop_id" value="<?=$shop->id?>"/>
                        <div class="col-md-1 col-xs-6 business_hrs_inner">
                          <input type="checkbox" name="shop_name[]" id="radioo<?=$i?>" class="css-checkbox" value="<?=$shop->id?>">
                          <label for="radioo<?=$i?>" class="css-label css-label-check"></label>
                        </div>
                      </div>

                    </div>
                  </div>
                  <?php }?>
            
                  <div class="col-md-8 col-md-offset-1 policy" style="margin-left: 13%">
                      <button type="button" id="prev1" class="buttons shopbutton left">Prev</button>
                      <button type="button" id="next2" class="buttons shopbutton right">Next</button>
                  </div>
             </div>
           </section>
           <section id="content3">
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
                    <button type="button" id="prev2" class="buttons shopbutton left">Prev</button>
                    <button type="button" id="next3" class="buttons shopbutton right">Next</button>
                </div>
              </div>
           </section>
           <section id="content4">
             <div class="edit-form shop-form">
               <div class="col-md-12 col-xs-12"  style="text-align: center !important;">
                    <span class="form-title">Select Break Hours<span class="cls_star">*</span></span>
                 </div>
                <div class="col-md-12 col-md-offset-2" style="height: 50px;">
                  <div class="col-md-3 bis_hours">
                    <input type="checkbox" name="" id="break_chkbx1" checked="checked" class="css-checkbox"><label for="break_chkbx1" class="css-label css-label-check dayCB">Monday</label>
                  </div>
                    <div id="datepairExample1" style="float:left;">
                      <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="Monday_break1" name="Monday_break1" value="9:00 AM">
                      <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="Monday_break2" name="Monday_break2" value="5:00 PM">
                    </div>
                  </p>
                </div>
                <div class="col-md-12 col-md-offset-2" style="height: 50px;">
                  <div class="col-md-3 bis_hours">
                    <input type="checkbox" name="" id="break_chkbx2" checked="checked" class="css-checkbox"><label for="break_chkbx2" class="css-label css-label-check dayCB">Tuesday</label>
                  </div>
                  <div id="datepairExample1" style="float:left;">
                    <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="tuesday_break1" name="tuesday_break1" value="9:00 AM">
                    <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="tuesday_break2" name="tuesday_break2" value="5:00 PM">
                  </div>
                </div>
                <div class="col-md-12 col-md-offset-2" style="height: 50px;">
                  <div class="col-md-3 bis_hours">
                    <input type="checkbox" name="" id="break_chkbx3" checked="checked" class="css-checkbox"><label for="break_chkbx3" class="css-label css-label-check dayCB">Wednesday</label>
                  </div>
                  <div id="datepairExample1" style="float:left;">
                    <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="wednesday_break1" name="wednesday_break1" value="9:00 AM">
                    <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="wednesday_break2" name="wednesday_break2" value="5:00 PM">
                  </div>
                </div>
                <div class="col-md-12 col-md-offset-2" style="height: 50px;">
                  <div class="col-md-3 bis_hours">
                    <input type="checkbox" name="" id="break_chkbx4" checked="checked" class="css-checkbox"><label for="break_chkbx4" class="css-label css-label-check dayCB">Thursday</label>
                  </div>
                  <div id="datepairExample1" style="float:left;">
                    <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="thursday_break1" name="thursday_break1" value="9:00 AM">
                    <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="thursday_break2" name="thursday_break2" value="5:00 PM">
                  </div>
                </div>
                <div class="col-md-12 col-md-offset-2" style="height: 50px;">
                  <div class="col-md-3 bis_hours">
                    <input type="checkbox" name="" id="break_chkbx5" checked="checked" class="css-checkbox"><label for="break_chkbx5" class="css-label css-label-check dayCB">Friday</label>
                  </div>
                  <div id="datepairExample1" style="float:left;">
                    <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="friday_break1" name="friday_break1" value="9:00 AM">
                    <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="friday_break2" name="friday_break2" value="5:00 PM">
                  </div>
                </div>
                <div class="col-md-12 col-md-offset-2" style="height: 50px;">
                    <div class="col-md-3 bis_hours">
                    <input type="checkbox" name="" id="break_chkbx6" class="css-checkbox"><label for="break_chkbx6" class="css-label css-label-check dayCB">Saturday</label>
                    </div>
                    <div id="datepairExample1" style="float:left;">
                      <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="saturday_break1" name="saturday_break1" style="display:none;">
                      <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="saturday_break2" name="saturday_break2" style="display:none;">
                    </div>
                </div>
                <div class="col-md-12 col-md-offset-2" style="height: 50px;">
                    <div class="col-md-3 bis_hours">
                    <input type="checkbox" name="" id="break_chkbx7" class="css-checkbox"><label for="break_chkbx7" class="css-label css-label-check dayCB">Sunday</label>
                    </div>
                    <div id="datepairExample1" style="float:left;">
                      <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="sunday_break1" name="sunday_break1" style="display:none;">
                      <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="sunday_break2" name="sunday_break2" style="display:none;">
                    </div>
                </div>
                <div class="col-md-8 col-md-offset-1 policy" style="margin-left: 13%">
                    <button type="button" id="prev3" class="buttons shopbutton left">Prev</button>
                    <button type="button" id="next4" class="buttons shopbutton right">Next</button>
                </div>
            </div>
            </section>
            <section id="content5">
              <div class="edit-form shop-form">
                <div class="col-md-12 col-xs-12"  style="text-align: center !important;">
                   <span class="form-title">Workers Vacation <span class="cls_star">*</span></span>
                </div>
                <div class="col-md-12 bis_hours">
                  <input type="checkbox" name="worker_vacation" id="worker_vacation" class="css-checkbox">
                  <label for="worker_vacation" class="css-label css-label-check" style="font-size: 16px;">Workers Vacation</label>
                </div>
               <div class="col-md-12 vacation_module" style="display:none;">
                  <div class="col-md-12">
                     <div class="col-md-3" style="margin: 5px 0 20px 0">
                       <label style="margin-left: 20px;">Start Date</label>
                     </div>
                     <div class="col-md-3">
                      <input type="text" name="vacation_start_date" id="vacation_start_date" class="select_date" autocomplete="off">
                     </div>
                     <!-- <div class="col-md-3">
                        <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="vacation_start_time" name="vacation_start_time" value="">
                      </div> -->
                      <div id="datepairExample1">
                        <input type="text" class="time start ui-timepicker-input cls-time-input form-control" id="vacation_start_time" name="vacation_start_time" autocomplete="off">
                      </div>
                  </div>
                  <div class="col-md-12">
                     <div class="col-md-3" style="margin: 5px 0 20px 0">
                       <label style="margin-left: 20px;">End Date</label>
                     </div>
                     <div class="col-md-3">
                     <input type="text" name="vacation_end_date" id="vacation_end_date" class="select_date">
                     </div>
                     <!-- <div class="col-md-3">
                        <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="vacation_end_time" name="vacation_end_time" value="">
                     </div> -->
                     <div id="datepairExample1">
                       <input type="text" class="time end ui-timepicker-input cls-time-input form-control" id="vacation_end_time" name="vacation_end_time">
                     </div>
                  </div>
                  <div class="col-md-9" style="margin-top:3px;">
                   <div class="col-md-3" style="padding-left: 34px;">
                      <label class="cl_lbl_time1">All Day</label>
                  </div>
                   <div class="col-md-3" style="padding-left: 28px;">
                      <div class="form-group switch_title">
                        <label class="switch">
                          <input type="checkbox" class="appoinemnt_slider" id="all_day" name="all_day">
                          <span class="slider round"></span>
                        </label>
                    </div>
                   </div>
                  </div>
                </div>
                <div class="col-md-10">
                  <button type="button" id="prev4" class="buttons shopbutton left">Prev</button>
                   <button type="button" id="next5" class="buttons shopbutton right">Next</button>
                </div>
                
                </div>
            </section>



        <section id="content6">
              <div class="edit-form shop-form">
                <div class="col-md-12 col-xs-12">
                    <span class="form-title">Select Services <span class="cls_star">*</span></span>
                </div>
               
                      

                  <div class="col-md-12 col-xs-12 margin_bottom_30">
                    <div class="business_hrs">
                      <div class="col-md-12 col-xs-12" id="my_worker_service_list">
                        
                 

                      </div>

                    </div>
                  </div>
                
            
                  <div class="col-md-8 col-md-offset-1 policy" style="margin-left: 13%">
                      <button type="button" id="prev5" class="buttons shopbutton left">Prev</button>
                     

                      <button type="submit" id="submitButton" class="buttons shopbutton right">Submit</button>
                  </div>
                  
             </div>
           </section>















      <!-- </form></section></main></div></div></div></div></div></section> -->

      </div>
    </div>
    </div>
  </div>
</section>

</form>
<script>
  //var checked1=[];
   $(document).ready(function() {
    
//     $('.css-checkbox').click(function(){
 
//   let check = $("#content2 .css-checkbox");
// for(let i=0;i<check.length;i++){
//   let tt = $(check[i]);
// let tmp = tt.is(":checked");
// if(tmp){
//   checked1.push(tt.val());
// }else{
//   let idx = checked1.indexOf(tt.val());
//   checked1.splice(idx,1);
// }
// //console.log(checked1);
// $('#all_shop_id').val(checked1);

// }
// });

$('#next2').click(function(){

   var lang = [];

           $("input[name='shop_name[]']:checked").each(function(){
            lang.push(this.value);
        });
var datastring = lang;

$.ajax({
            url: "<?php echo base_url(); ?>worker/get_worker_shop_services",
            type: 'post',
            data: {datastring:datastring},
            success: function(data){
              var data1 = JSON.parse(data);
              console.log(data1);
              console.log(data1.length);
             var html = '';
              for (var i = 0; i < data1.length; i++) {
             //    html += '<option value="'+ data1[i].category_id +'">'+ data1[i].cat_name +'</option>';
             // html += '<span>'+ data1[i][0].cat_name +'</span><br>';

              html += "<div class='col-md-11 col-xs-18'><span>"+ data1[i][0].service_name +"</span><br> <span style='font-size: 16px; color: rgba(0, 0, 0, 0.502);'> "+ data1[i][0].cat_name +"</span></div> <div class='col-md-1 col-xs-6 '><input type='checkbox' name='service_list_all[]' id='radio"+ data1[i][0].id +"' class='css-checkbox' value='"+ data1[i][0].id +"' ><label for='radio"+ data1[i][0].id +"' class='css-label css-label-check'></label></div>";

              }
              $('#my_worker_service_list').html(html);
            }
        });


       });

     $("#submitButton").click(function(){
       if($("#worker_vacation").is(':checked')){
         if($("#vacation_start_date").val() == '' || $("#vacation_end_date").val() == ''){
           $.alert({
               title: 'Alert!',
               content: 'Please fill start and/or end date!',
           });
           return false;
         }
       }
       if($("#all_day").is(':unchecked')){
         if($("#vacation_start_time").val() == '' || $("#vacation_end_time").val() == ''){
           $.alert({
               title: 'Alert!',
               content: 'Please fill start and/or end time!',
           });
           return false;
         }
       }
     });
     $("#vacation_start_date").datepicker({
        numberOfMonths: 2,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#vacation_end_date").datepicker("option", "minDate", dt);
        }
    });
    $("#vacation_end_date").datepicker({
        numberOfMonths: 2,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#vacation_start_date").datepicker("option", "maxDate", dt);
        }
    });
     $("#all_day").click(function(){
       if ($(this).is(':checked')) {
         $("#vacation_end_time").hide(); $("#vacation_end_time").val('');
         $("#vacation_start_time").hide(); $("#vacation_start_time").val('');
        // return confirm("Are you sure?");
      }else{
        $("#vacation_end_time").show(); $("#vacation_end_time").val('9:00 AM');
        $("#vacation_start_time").show(); $("#vacation_start_time").val('5:00 PM');
      }
    });
    $("#worker_vacation").click(function(){
      if ($(this).is(':checked')) {
        $(".vacation_module").show();
        $("#vacation_start_date").val('');
        $("#vacation_end_date").val('');
        $("#vacation_start_time").val('');
        $("#vacation_end_time").val('');
      }else{
        $(".vacation_module").hide();
      }
    });
     $('#tab2, #tab3, #tab4, #tab5, #tab6').click(function() {
        var worker_name = $("#worker_name").valid();
        var worker_email = $("#worker_email").valid();
        var mobile_no = $("#worker_mobile").valid();
        var address_1 = $("#worker_percentage").valid();
        if(worker_name == false || worker_email == false || mobile_no == false || address_1 == false){
          $.alert({
              title: 'Alert!',
              content: 'Please fill all the Shop info!',
          });
          $('#tab1').trigger('click');
        }
     });
     $('#tab3, #tab4, #tab5, #tab6').click(function() {
       if($('input[name="shop_name[]"]:checked').length == 0){
         $.alert({
             title: 'Alert!',
             content: 'Please select Shop!',
         });
         $('#tab2').trigger('click');
       }
     });
     $("#add_worker").validate({
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
        address_1:"required"
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
        address_1: "Please specify Address"
      }
    });
     $("#next1").click(function(){   $('#tab2').trigger('click');  });
     $("#next2").click(function(){   $('#tab3').trigger('click');  });
     $("#next3").click(function(){   $('#tab4').trigger('click');  });
     $("#next4").click(function(){   $('#tab5').trigger('click');  });
     $("#next5").click(function(){   $('#tab6').trigger('click');  });

     $("#prev1").click(function(){   $('#tab1').trigger('click');  });
     $("#prev2").click(function(){   $('#tab2').trigger('click');  });
     $("#prev3").click(function(){   $('#tab3').trigger('click');  });
     $("#prev4").click(function(){   $('#tab4').trigger('click');  });
     $("#prev5").click(function(){   $('#tab5').trigger('click');  });
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

/////////////// Working Hours Click Start ////////////
  $("#gift_chkbx1").click(function () {
    if ($(this).is(":checked")) {
      $("#Monday1").show(); $("#Monday1").val("9:00 AM"); $("#Monday2").show(); $("#Monday2").val("5:00 PM");
    } else {
        $("#Monday1").hide(); $("#Monday2").hide(); $("#Monday1").val(""); $("#Monday2").val("");
        $("#Monday_break1").hide(); $("#Monday_break2").hide(); $("#Monday_break1").val(""); $("#Monday_break2").val("");
    }
  });
  $("#gift_chkbx2").click(function () {
      if ($(this).is(":checked")) {
        $("#tuesday1").show(); $("#tuesday2").show(); $("#tuesday1").val("9:00 AM"); $("#tuesday2").val("5:00 PM");
    } else {
        $("#tuesday1").hide(); $("#tuesday2").hide(); $("#tuesday1").val(""); $("#tuesday2").val("");
        $("#tuesday_break1").hide(); $("#tuesday_break2").hide(); $("#tuesday_break1").val(""); $("#tuesday_break2").val("");
    }
  });
  $("#gift_chkbx3").click(function () {
      if ($(this).is(":checked")) {
        $("#wednesday1").show(); $("#wednesday2").show(); $("#wednesday1").val("9:00 AM"); $("#wednesday2").val("5:00 PM");
    } else {
      $("#wednesday1").hide(); $("#wednesday2").hide(); $("#wednesday1").val(""); $("#wednesday2").val("");
      $("#wednesday_break1").hide(); $("#wednesday_break2").hide(); $("#wednesday_break1").val(""); $("#wednesday_break2").val("");
    }
  });
  $("#gift_chkbx4").click(function () {
      if ($(this).is(":checked")) {
        $("#thursday1").show(); $("#thursday2").show(); $("#thursday1").val("9:00 AM"); $("#thursday2").val("5:00 PM");
    } else {
      $("#thursday1").hide(); $("#thursday2").hide(); $("#thursday1").val(""); $("#thursday2").val("");
      $("#thursday_break1").hide(); $("#thursday_break2").hide(); $("#thursday_break1").val(""); $("#thursday_break2").val("");
      }
  });
  $("#gift_chkbx5").click(function () {
      if ($(this).is(":checked")) {
        $("#friday1").show(); $("#friday2").show(); $("#friday1").val("9:00 AM"); $("#friday2").val("5:00 PM");
    } else {
      $("#friday1").hide(); $("#friday2").hide(); $("#friday1").val(""); $("#friday2").val("");
      $("#friday_break1").hide(); $("#friday_break2").hide(); $("#friday_break1").val(""); $("#friday_break2").val("");
      }
  });
  $("#gift_chkbx6").click(function () {
      if ($(this).is(":checked")) {
        $("#saturday1").show(); $("#saturday2").show(); $("#saturday1").val("9:00 AM"); $("#saturday2").val("5:00 PM");
    } else {
      $("#saturday1").hide(); $("#saturday2").hide(); $("#saturday1").val(""); $("#saturday2").val("");
      $("#saturday_break1").hide(); $("#saturday_break2").hide(); $("#saturday_break1").val(""); $("#saturday_break2").val("");
      }
  });
  $("#gift_chkbx7").click(function () {
      if ($(this).is(":checked")) {
        $("#sunday1").show(); $("#sunday2").show(); $("#sunday1").val("9:00 AM"); $("#sunday2").val("5:00 PM");
    } else {
      $("#sunday1").hide(); $("#sunday2").hide(); $("#sunday1").val(""); $("#sunday2").val("");
      $("#sunday_break1").hide(); $("#sunday_break2").hide(); $("#sunday_break1").val(""); $("#sunday_break2").val("");
    }
  });
/////////////// Working Hours Click End ////////////
/////////////// Break Click Start ////////////
  $("#break_chkbx1").click(function () {
      if ($(this).is(":checked")) {
        $("#Monday_break1").show(); $("#Monday_break2").show(); $("#Monday_break1").val("9:00 AM"); $("#Monday_break2").val("5:00 PM");
    } else {  $("#Monday_break1").hide(); $("#Monday_break2").hide(); $("#Monday_break1").val(""); $("#Monday_break2").val("");
    }
  });
  $("#break_chkbx2").click(function () {
      if ($(this).is(":checked")) {
        $("#tuesday_break1").show(); $("#tuesday_break2").show(); $("#tuesday_break1").val("9:00 AM"); $("#tuesday_break2").val("5:00 PM");
    } else { $("#tuesday_break1").hide(); $("#tuesday_break2").hide(); $("#tuesday_break1").val(""); $("#tuesday_break2").val("");
      }
  });
  $("#break_chkbx3").click(function () {
      if ($(this).is(":checked")) {
        $("#wednesday_break1").show(); $("#wednesday_break2").show(); $("#wednesday_break1").val("9:00 AM"); $("#wednesday_break2").val("5:00 PM");
    } else {
      $("#wednesday_break1").hide(); $("#wednesday_break2").hide(); $("#wednesday_break1").val(""); $("#wednesday_break2").val("");
      }
  });
  $("#break_chkbx4").click(function () {
      if ($(this).is(":checked")) {
        $("#thursday_break1").show(); $("#thursday_break2").show(); $("#thursday_break1").val("9:00 AM"); $("#thursday_break2").val("5:00 PM");
    } else { $("#thursday_break1").hide(); $("#thursday_break2").hide(); $("#thursday_break1").val(""); $("#thursday_break2").val("");
      }
  });
  $("#break_chkbx5").click(function () {
      if ($(this).is(":checked")) {
        $("#friday_break1").show(); $("#friday_break2").show(); $("#friday_break1").val("9:00 AM"); $("#friday_break2").val("5:00 PM");
    } else { $("#friday_break1").hide(); $("#friday_break2").hide();$("#friday_break1").val(""); $("#friday_break2").val("");
      }
  });
  $("#break_chkbx6").click(function () {
      if ($(this).is(":checked")) {
        $("#saturday_break1").show(); $("#saturday_break2").show(); $("#saturday_break1").val("9:00 AM"); $("#saturday_break2").val("5:00 PM");
    } else { $("#saturday_break1").hide(); $("#saturday_break2").hide(); $("#saturday_break1").val(""); $("#saturday_break2").val("");
      }
  });
  $("#break_chkbx7").click(function () {
      if ($(this).is(":checked")) {
        $("#sunday_break1").show(); $("#sunday_break2").show(); $("#sunday_break1").val("9:00 AM"); $("#sunday_break2").val("5:00 PM");
    } else { $("#sunday_break1").hide(); $("#sunday_break2").hide(); $("#sunday_break1").val(""); $("#sunday_break2").val("");
      }
  });
  /////////////// Break Click End ////////////
});
</script>
