<?php $this->load->view('templates/_include/header_view1'); ?>
<style media="screen">
.leftbox{
  width: 49% !important;
}
  @media only screen and (max-width:480px){
    .leftbox{
      width: 100% !important;
    }
  }
</style>
 <div class="container">
   <div class="col-md-12" style="margin-top: 60px;margin-bottom: 20px;">
     <div class="cls_main_section product_round_sub" id="load_data">
     </div>
   </div>
   <div class="col-md-12">
     <div id="load_data_message" style="text-align:center;"></div>
   </div>
   <input type="hidden" name="view_more_data" id="view_more_data" value="0">
 </div>

<script type="text/javascript">
  var site_url = $("#site_url").val();
</script>

<script type="text/javascript">
$(document).ready(function(){
 var eop = 0;
 var limit = 3;
 var start = 0;
 var action = 'inactive';
 function load_country_data(limit, start)
 {
  $.ajax({
   url:site_url+'favourite/favourite_data',
   method:"POST",
   data:{limit:limit, start:start},
   cache:false,
   success:function(data)
   {
     var data1 = JSON.parse(data);
     var data_servicelist = data1['service_list'];
     var data_total_service = data1['all_service'];
     if(data_total_service <= 3){
       $('#load_data_message').hide();
     }else{
       $('#load_data_message').show();
     }
     var data_limit = $('#view_more_data').val();
     if(data_servicelist.length  != 0){
        var all_data = data_servicelist[0].check_worker_service;
        $('#view_more_data').val(all_data);
        // $('#load_data_message').show();
     }else{
       var all_data = '';
       $('#view_more_data').hide();
       $('#load_data_message').hide();
        action = 'active';
     }
     var html =  "";
     // alert(data_servicelist.length);
     if(data_servicelist.length > 0){
       for (var i = 0; i < data_servicelist.length; i++) {
         var allimage = data_servicelist[i].main_image;
         var rating = "";
         for (var j = 0; j < 5; j++) {
           if(j < data_servicelist[i].ratingRound)
           {
             rating += '<span class="fa fa-star checked" id="star-'+j+'"></span>';
           }
           else
           {
             rating += '<span class="fa fa-star" id="star-'+j+'"></span>';
           }
         }
         var cat;
         var parent_cat;
         if(data_servicelist[i].und_sub_category != undefined)
         {
           cat = data_servicelist[i].und_sub_category.cat_name+' - '+data_servicelist[i].sub_category.cat_name;
           parent_cat = data_servicelist[i].service_name;
         }
         else if(data_servicelist[i].sub_category != undefined){
           cat = data_servicelist[i].sub_category.cat_name;
           parent_cat = data_servicelist[i].service_name;
         }else{
           cat = data_servicelist[i].service_name;
           parent_cat = '';
         }

         html += '<div class="col-md-6 leftbox"><div class="col-md-5"><a href="'+site_url+'detail/shop_detail/'+data_servicelist[i].encrypt_id+'"><img src="'+allimage+'" width="200px" height="150px"></a></div><div class="col-md-7"><div style="float: right;">'+rating+'</div><h3 class="cls_service_header">'+cat+'</h3><p class="cls_service_p">'+parent_cat+'<br>'+data_servicelist[i].shop_name+'</p><h2 class="cls_service_price">$'+data_servicelist[i].price+'</h2><div class="buttons"><a href="'+site_url+'appointment/appointment_step1/'+data_servicelist[i].encrypt_shop_id+'/'+data_servicelist[i].encrypt_id+'" style="color:#fff;">Book Now</a></div></div></div>';
       }
   }else{
    if(eop == 0){
      html+="<h2 style='text-align:center; width:100%; float:left; clear:both;'>You dont have any favorites now.</h2>";
      eop = eop + 1;
    }
      // return false;
   }
   $('#load_data').append(html);
     // $('#load_data').append(data);
     var m_url = '<?php base_url()?>front/images/loader.gif';
     $('#load_data_message').html("<img src="+m_url+">");
     action = "inactive";
   }
  });
 }

 if(action == 'inactive')
 {
  action = 'active';
  load_country_data(limit, start);
 }
 $(window).scroll(function(){
  if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
  {
   action = 'active';

   // start = start + limit;
   start = $('#view_more_data').val();
   setTimeout(function(){
    load_country_data(limit, start);
  }, 3000);
  }
 });

});
</script>
