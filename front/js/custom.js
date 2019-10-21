$(document).ready(function($) {

  	var site_url = $("#site_url").val();

    $(document).on('click', "#all_shop_view_more", function () {
     var data_limit = $('#count_shops').val();
     var search_result = $('#search_result').val();

     // alert(filter_services);
     $.ajax({
         type: 'POST',
         url: site_url+'home/search_shop_data',
         data:'data_limit='+data_limit+'&search_result='+search_result,
         beforeSend: function () {
             // $('.loading').show();
         },
         success: function (data) {
           console.log(data);
           var data1 = JSON.parse(data);
           console.log(data1);
           var data_limit = $('#count_shops').val();
           var all_shops = parseInt(data_limit) + 4;
           $('#count_shops').val(all_shops);
           if(data1.length == 0){
              $(".cls_shop_view_more").hide();
           }else{
             var total_count_shop = data1[0].count_data;
             var total_shop_result = data1[0].total_shop_result;
             if(total_shop_result <= total_count_shop){
                $(".cls_shop_view_more").hide();
             }
           }
           var html =  "";

           for (var i = 0; i < data1.length; i++) {
             var allimage = data1[i].main_image;
             var main_url;
             var unclaime;
             if(data1[i].varification == 1)
             {
               unclaime = '<div class="top-right unclaime">Unclaimed</div>';
               main_url = '#'
             }
             else {
               unclaime = '';
               main_url = site_url+'shop/services/'+data1[i].shop_id;
             }

             html += '<div class="col-md-3 col-sm-6 col-xs-12"><div class="related_service_item_main"><div class="related_service_item"><div class="home_img"><a href="'+main_url+'"><img src="'+allimage+'" class="img-responsive" style="height:170px;width:auto;display:inline;border-radius:10px;"></a>'+unclaime+'</div><h3 class="cls_h3_shop_name">'+data1[i].shop_name+'</h3></div></div></div>';
           }
           $('.shop_filter_data').append(html);
         }
     });
    });

    $(document).on('click', "#all_services_view_more", function () {
     var data_limit = $('#count_services').val();
     // alert(data_limit);
     var search_result = $('#search_result').val();

     // alert(filter_services);
     $.ajax({
         type: 'POST',
         url: site_url+'home/search_services_data',
         data:'data_limit='+data_limit+'&search_result='+search_result,
         beforeSend: function () {
             // $('.loading').show();
         },
         success: function (data) {
           // console.log(data);
           var data1 = JSON.parse(data);
           console.log(data1);
           if(data1.length == 0){
              $(".cls_service_view_more").hide();
           }else{
             var all_shops = data1[0].check_worker_service;
             $('#count_services').val(all_shops);
             var total_count_shop = data1[0].count_result;
             var total_shop_result = data1[0].total_service_result;
             if(total_shop_result <= total_count_shop){
                $(".cls_service_view_more").hide();
             }
           }
           var html =  "";

           for (var i = 0; i < data1.length; i++) {
             var allimage = data1[i].main_image;
             var heart = (data1[i].fav == "1")  ? 'fa-heart' : 'fa-heart-o';

              var rating = "";
              for (var j = 0; j < 5; j++) {
                if(j < data1[i].ratingRound)
                {
                  rating += '<i class="fa fa-star fa-2x star-checked" id="star-'+j+'" style="margin-right: 3px;"></i>';
                }
                else
                {
                  rating += '<i class="fa fa-star fa-2x" id="star-'+j+'" style="margin-right: 3px;"></i>';
                }
              }

              var cat;
              if(data1[i].und_sub_category != undefined)
              {
                cat = data1[i].und_sub_category.cat_name+' - '+data1[i].sub_category.cat_name;
              }
              else if(data1[i].sub_category != undefined){
                cat = data1[i].sub_category.cat_name;
              }else{
                cat = '';
              }

              if(cat == ''){
                var star_style = 'style="margin-bottom: 54px;"';
              }else{
                var star_style = '';
              }

             html += '<div class="col-md-3 col-sm-6 col-xs-12"><div class="related_service_item_main"><div class="related_service_item"><div class="like_dislike"><i class="fa '+heart+' heart_like_dislike" data-shopid="'+data1[i].shop_id+'" data-serviceid="'+data1[i].id+'" data-userid="'+data1[i].UserId+'" aria-hidden="true"></i> </div><div class="home_img"><a href="'+site_url+'detail/shop_detail/'+data1[i].encrypt_id+'"><img src="'+allimage+'" class="img-responsive" style="height: 170px;width:auto;display: inline; border-radius:10px;"></a></div><h3>'+cat+'</h3><a href="'+site_url+'detail/shop_detail/'+data1[i].encrypt_id+'"><p>'+data1[i].service_name+' -  $'+data1[i].price+'</p></a><span>'+data1[i].shop_name+'</span> <div class="star-container" '+star_style+'>'+rating+'<span>('+data1[i].review_list+')</span></div></div></div></div>';

           }
           $('.service_filter_data').append(html);
         }
     });
    });

    $(document).on('click', "#view_more_shop_details", function () {
     var data_limit = $('#count_services').val();
     var shop_id = $('#shop_id').val();
     var shop_id_encrypt = $('#shop_id_encrypt').val();

     // alert(filter_services);
     $.ajax({
         type: 'POST',
         url: site_url+'shop/search_services_data',
         data:'data_limit='+data_limit+'&shop_id='+shop_id,
         beforeSend: function () {
             // $('.loading').show();
         },
         success: function (data) {
           // console.log(data);
           var data1 = JSON.parse(data);
           console.log(data1);
           // var data1 = JSON.parse(data);
           if(data1.length == 0){
              $("#view_more_shop_details").hide();
              $("#view_more_shop_details").css("color", "grey");
           }else{
             var data_limit = $('#count_services').val();
             var all_shops = parseInt(data_limit) + 4;

              $('#count_services').val(all_shops);
           }
            // return false;
           var html =  "";

           for (var i = 0; i < data1.length; i++) {
             var allimage = data1[i].main_image;
             var heart = (data1[i].fav == "1")  ? 'fa-heart' : 'fa-heart-o';

             // if(main_image != ''){
             //   var allimage = site_url+'assets/uploads/service_image/'+main_image;
             // }
             // else {
             //   var allimage = site_url+'front/images/banner.jpg';
             // }
              var rating = "";
              for (var j = 0; j < 5; j++) {
                if(j < data1[i].ratingRound)
                {
                  rating += '<i class="fa fa-star fa-2x star-checked" id="star-'+j+'" style="margin-right: 3px;"></i>';
                }
                else
                {
                  rating += '<i class="fa fa-star fa-2x" id="star-'+j+'" style="margin-right: 3px;"></i>';
                }
              }

              var cat;
              if(data1[i].und_sub_category != undefined)
              {
                cat = data1[i].und_sub_category.cat_name+' - '+data1[i].sub_category.cat_name;
              }
              else {
                cat = data1[i].sub_category.cat_name;
              }

             html += '<div class="col-md-3 col-sm-6 col-xs-12"><div class="related_service_item_main"><div class="related_service_item"><div class="like_dislike"><i class="fa '+heart+' heart_like_dislike" data-shopid="'+data1[i].shop_id+'" data-serviceid="'+data1[i].id+'" data-userid="'+data1[i].UserId+'" aria-hidden="true"></i> </div><div class="home_img"><a href="'+site_url+'detail/shop_detail/'+shop_id+'/'+data1[i].encrypt_id+'"><img src="'+allimage+'" class="img-responsive" style="height: 170px;width:auto;display: inline; border-radius:10px;"></a></div><h3>'+cat+'</h3><a href="'+site_url+'detail/shop_detail/'+shop_id_encrypt+'/'+shop_id+'/'+data1[i].encrypt_id+'"><p>'+data1[i].service_name+' -  $'+data1[i].price+'</p></a><span>'+data1[i].shop_name+'</span> <div class="star-container">'+rating+'<span>('+data1[i].review_list+')</span></div></div></div></div>';

           }
           $('.service_filter_data').append(html);
         }
     });
    });

	// document.getElementById("myForm").submit();

	$(".headerSearch").autocomplete({
        source: function( request, response ) {
            $.ajax( {
                url: site_url + 'home/GetSearchData',
                type: "POST",
                dataType: "json",
                data: {
                term: request.term,
                },
                success: function( data ) {
                	/*console.log(data);
                	return false;*/
                    response( data );
                }
            } );
        },
        select: function(event, ui) {
        	// console.log('ui',ui); return false;
        	// var id = ui.item.id;
        	// var key = ui.item.key;
        	// window.location.replace(site_url+'detail/shop_detail/'+id);
        },
        change: function( event, ui ){

        },
        response: function( event, ui ) {

        }
    });

    /*$(".advance_search").click(function() {
        $('html, body').animate({
            scrollTop: $(".home_filter").offset().top
        }, 800);
    });*/

});

function movetoNext(current, nextFieldID) {
    if (current.value.length >= current.maxLength) {
      $("."+nextFieldID).focus();
    }
}
