var mapLoc = "";
var site_url = $("#site_url").val();
var near_home_services = 0;
var main_filter_services = 1;
var location_services = 1;

$(document).ready(function() {
  if(near_home_services == 0){
    initMap();
  }
  $(function() {
        $('.datetimepicker1').datetimepicker({
           format: 'MM-DD-YYYY',
           // defaultDate:new Date()
        });
    $('.input-group-addon').on('click', function() {
     $(this).prev('.datetimepicker1').data('DateTimePicker').toggle();
    });
  });

    var related_service_carousel = $('.related_service_carousel');
    related_service_carousel.owlCarousel({
       margin: 0,
       nav: false,
       loop: false,
       items: 4,
       rewind: true,
       responsive: { 0: { items: 1 }, 850: { items: 2 }, 1240: { items: 3 } }
    })

    $('.related_service_carousel_customNextBtn').click(function() { related_service_carousel.trigger('next.owl.carousel'); })
    $('.related_service_carousel_customPrevBtn').click(function() { related_service_carousel.trigger('prev.owl.carousel', [300]); })


    $("#showmap").click(function(){
       $("#map_show_hide").toggle();
       if($("#map_show_hide").is(":visible")){
         $(".cls_services_div").addClass("intro");
       }else{
         $(".cls_services_div").removeClass("intro");
       }
   });

  $(".btn_reset_service" ).click(function() {
     near_home_services = 0;
     main_filter_services = 1;
     location_services = 1;

     $('#total_all_services').val('0')
     $('.near_home_services').html('');
     $('.homeFilter').html('');

    $('#filter_services').val('');
    $('#filter_shops').val('');
    $('#filter_sorting').val('');
    $('#filter_date').val('');
    $('#filter_min_price').val('1');
    $('#filter_max_price').val('0');
    $('.cls_main_output').val('0');
    $('#filter_location').val('');

    if(near_home_services == 0){
      initMap();
    }
   });

   $(".btn_filter_service" ).click(function() {

     $('#total_all_services').val('0')
     $('.near_home_services').html('');
    $('.homeFilter').html('');

    var total_all_services = $('#total_all_services').val();
    var filter_services = $('#filter_services').val();
    var filter_shops = $('#filter_shops').val();
    var filter_sorting = $('#filter_sorting').val();
    var filter_date = $('#filter_date').val();
    var filter_min_price = '1';
    var filter_max_price = $('#filter_max_price').val();
    var filter_location = $('#filter_location').val();

    if(filter_services == '' && filter_shops == '' && filter_sorting == '' && filter_date == '' && filter_max_price == '0' && filter_location == ''){
      near_home_services = 0;
      main_filter_services = 1;
      location_services = 1;

      if(near_home_services == 0){
         initMap();
      }
    }else{
      near_home_services = 1;
      main_filter_services = 0;
      location_services = 1;

      if(main_filter_services == 0){
        if(filter_max_price == 0){
          filter_max_price = '';
          filter_min_price = '';
        }
        var limit = 4;
        var start = 0;
        var action = 'inactive';
        function load_country_data(limit, start)
        {
          $.ajax({
              type: 'POST',
              url: site_url+'home/filter_services',
              data:'filter_services='+filter_services+'&filter_shops='+filter_shops+'&filter_sorting='+filter_sorting+'&filter_date='+filter_date+'&filter_min_price='+filter_min_price+'&filter_max_price='+filter_max_price+'&filter_location='+filter_location+'&total_all_services='+start,
              beforeSend: function () {
              },
              success: function (data) {
                var data_main = JSON.parse(data);
                console.log(data_main);
                var data1 = data_main['services_list'];
                var data_shoplist = data_main['shop_list'];
                var data_total_services = data_main['total_services'];
                var all_total_services = data_main['all_total_services'];
                var data_total_service_main = data_main['total_worker_service'];
                $('#total_all_services').val(data_total_services);

                if(data_total_services == 0){
                  var html1 = "<p>No services found</p>";
                  $('.near_home_services').html(html1);
                    $('#load_data_message').hide();
                    action = 'active';

                    var markers = data_shoplist;
                    if(markers.length > 0)
                    {
                      var mapOptions = {
                        center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                        zoom: 10,
                        fullscreenControl: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                        mapLoc = map;
                        var infoWindow = new google.maps.InfoWindow();
                        var lat_lng = new Array();
                        var latlngbounds = new google.maps.LatLngBounds();
                        for (i = 0; i < markers.length; i++) {
                        var data = markers[i]
                        var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                        lat_lng.push(myLatlng);
                        var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: data.title
                        });
                        latlngbounds.extend(marker.position);
                        (function (marker, data) {
                        google.maps.event.addListener(marker, "click", function (e) {
                        infoWindow.setContent(data.description);
                        infoWindow.open(map, marker);
                        });
                        })(marker, data);
                        }
                        map.setCenter(latlngbounds.getCenter());
                        map.fitBounds(latlngbounds);
                    }
                    else
                    {
                      getLocation();
                    }

                  }else{
                    if(data_total_service_main <= 4){
                      $('#load_data_message').hide();
                    }else{
                      $('#load_data_message').show();
                      var m_url = site_url+'front/images/loader.gif';
                      $('#load_data_message').html("<img src="+m_url+">");
                      action = "inactive";
                    }
                  }
                    if(data_total_services <= all_total_services){
                    var html =  "";

                    for (var i = 0; i < data1.length; i++) {
                      var allimage = data1[i].main_image;
                      var heart = (data1[i].fav == "1")  ? 'fa-heart' : 'fa-heart-o';

                       var rating = "";
                       for (var j = 0; j < 5; j++) {
                         if(j < data1[i].ratingRound)
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
                       if(data1[i].und_sub_category != undefined)
                       {
                         cat = data1[i].und_sub_category.cat_name+' - '+data1[i].sub_category.cat_name;
                         parent_cat = data1[i].service_name;
                       }
                       else if(data1[i].sub_category != undefined){
                         cat = data1[i].sub_category.cat_name;
                         parent_cat = data1[i].service_name;
                       }else{
                         cat = data1[i].service_name;
                         parent_cat = '';
                       }

                       html += '<div class="col-md-6 leftbox" style="width:49%;"><div class="col-md-5"><a href="'+site_url+'detail/shop_detail/'+data1[i].shop_id+'/'+data1[i].encrypt_id+'"><img src="'+allimage+'" height="150px" width="200px"></a></div><div class="col-md-7"><div style="float: right;">'+rating+'</div><h3 class="cls_service_header">'+cat+'</h3><p class="cls_service_p">'+parent_cat+'<br>'+data1[i].shop_name+'</p><h2 class="cls_service_price">$'+data1[i].price+'</h2><div class="buttons"><a href="'+site_url+'appointment/appointment_step1/'+data1[i].shop_id+'/'+data1[i].encrypt_id+'" style="color:#fff;">Book Now</a></div></div></div>';
                    }
                    $('.homeFilter').append(html);

                    var markers4 = data_shoplist;
                    if(markers4.length > 0)
                    {
                      var mapOptions = {
                        center: new google.maps.LatLng(markers4[0].lat, markers4[0].lng),
                        zoom: 10,
                        fullscreenControl: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                        mapLoc = map;
                        var infoWindow = new google.maps.InfoWindow();
                        var lat_lng = new Array();
                        var latlngbounds = new google.maps.LatLngBounds();
                        for (i = 0; i < markers4.length; i++) {
                        var data = markers4[i]
                        var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                        lat_lng.push(myLatlng);
                        var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: data.title
                        });
                        latlngbounds.extend(marker.position);
                        (function (marker, data) {
                        google.maps.event.addListener(marker, "click", function (e) {
                        infoWindow.setContent(data.description);
                        infoWindow.open(map, marker);
                        });
                        })(marker, data);
                        }
                        map.setCenter(latlngbounds.getCenter());
                        map.fitBounds(latlngbounds);
                    }
                    else
                    {
                      getLocation();
                    }
                  }
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
          start = $('#total_all_services').val();
          setTimeout(function(){
           load_country_data(limit, start);
         }, 3000);
         }
        });
      }

    }
   });

    $("#filter_location").autocomplete({
      source: function( request, response ) {
          $.ajax( {
              url: site_url + 'profile/Get_zip_Data',
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


    $(document).on('keypress', "#filter_location", function (e) {
      var key = e.which;
      if(key == 13)  // the enter key code
      {
         near_home_services = 1;
         main_filter_services = 1;
         location_services = 0;

        if(location_services == 0){
          $('.near_home_services').html('');
          $('.homeFilter').html('');
          var limit2 = 4;
          var start2 = 0;
          var action2 = 'inactive2';
          function load_country_data2(limit2, start2)
          {
            var filter_services = $('#filter_services').val();
            var filter_shops = $('#filter_shops').val();
            var filter_sorting = $('#filter_sorting').val();
            var filter_date = $('#filter_date').val();
            var filter_min_price = $('#filter_min_price').val();
            var filter_max_price = $('#filter_max_price').val();
            var filter_location = $('#filter_location').val();
            if(filter_max_price == 0){
              filter_max_price = '';
              filter_min_price = '';
            }

            if(filter_location != ''){
              $.ajax({
                  type: 'POST',
                  url: site_url+'home/filter_services',
                  data:'filter_services='+filter_services+'&filter_shops='+filter_shops+'&filter_sorting='+filter_sorting+'&filter_date='+filter_date+'&filter_min_price='+filter_min_price+'&filter_max_price='+filter_max_price+'&filter_location='+filter_location+'&total_all_services='+start2,
                  beforeSend: function () {
                      // $('.loading').show();
                  },
                  success: function (data) {
                    var data1 = JSON.parse(data);
                    var data_servicelist = data1['services_list'];
                    var data_shoplist = data1['shop_list'];
                    var data_total_services = data1['total_services'];
                    var all_total_services = data1['all_total_services'];
                    var data_total_service_main = data1['total_worker_service'];
                    $('#total_all_services').val(data_total_services);

                    if(data_total_services == 0){
                      var html1 = "<p>No services found</p>";
                      $('.near_home_services').html(html1);
                      $('#load_data_message').hide();
                      action2 = 'active2';
                      $('#filter_location').val('');

                      var markers = data_shoplist;
                      if(markers.length > 0)
                      {
                        var mapOptions = {
                          center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                          zoom: 10,
                          fullscreenControl: false,
                          mapTypeId: google.maps.MapTypeId.ROADMAP
                          };
                          var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                          mapLoc = map;
                          var infoWindow = new google.maps.InfoWindow();
                          var lat_lng = new Array();
                          var latlngbounds = new google.maps.LatLngBounds();
                          for (i = 0; i < markers.length; i++) {
                          var data = markers[i]
                          var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                          lat_lng.push(myLatlng);
                          var marker = new google.maps.Marker({
                          position: myLatlng,
                          map: map,
                          title: data.title
                          });
                          latlngbounds.extend(marker.position);
                          (function (marker, data) {
                          google.maps.event.addListener(marker, "click", function (e) {
                          infoWindow.setContent(data.description);
                          infoWindow.open(map, marker);
                          });
                          })(marker, data);
                          }
                          map.setCenter(latlngbounds.getCenter());
                          map.fitBounds(latlngbounds);
                      }
                      else
                      {
                        getLocation();
                      }
                    }
                    else{
                      if(data_total_service_main <= 4){
                         $('#load_data_message').hide();
                         $('#filter_location').val('');
                      }else{
                        $('#load_data_message').show();
                        var m_url = site_url+'front/images/loader.gif';
                        $('#load_data_message').html("<img src="+m_url+">");
                        action2 = "inactive2";
                      }
                    }

                    if(data_total_services <= all_total_services){
                    var html =  "";

                    for (var i = 0; i < data_servicelist.length; i++) {
                      var allimage = data_servicelist[i].main_image;
                      var heart = (data_servicelist[i].fav == "1")  ? 'fa-heart' : 'fa-heart-o';

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

                       html += '<div class="col-md-6 leftbox" style="width:49%;"><div class="col-md-5"><a href="'+site_url+'detail/shop_detail/'+data_servicelist[i].encrypt_id+'"><img src="'+allimage+'" height="150px" width="200px"></a></div><div class="col-md-7"><div style="float: right;">'+rating+'</div><h3 class="cls_service_header">'+cat+'</h3><p class="cls_service_p">'+parent_cat+'<br>'+data_servicelist[i].shop_name+'</p><h2 class="cls_service_price">$'+data_servicelist[i].price+'</h2><div class="buttons"><a href="'+site_url+'appointment/appointment_step1/'+data_servicelist[i].shop_id+'/'+data_servicelist[i].encrypt_id+'" style="color:#fff;">Book Now</a></div></div></div>';
                    }
                    $('.homeFilter').append(html);

                    var markers1 = data_shoplist;
                    if(markers1.length > 0)
                    {
                      var mapOptions = {
                        center: new google.maps.LatLng(markers1[0].lat, markers1[0].lng),
                        zoom: 10,
                        fullscreenControl: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                        mapLoc = map;
                        var infoWindow = new google.maps.InfoWindow();
                        var lat_lng = new Array();
                        var latlngbounds = new google.maps.LatLngBounds();
                        for (i = 0; i < markers1.length; i++) {
                        var data = markers1[i]
                        var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                        lat_lng.push(myLatlng);
                        var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: data.title
                        });
                        latlngbounds.extend(marker.position);
                        (function (marker, data) {
                        google.maps.event.addListener(marker, "click", function (e) {
                        infoWindow.setContent(data.description);
                        infoWindow.open(map, marker);
                        });
                        })(marker, data);
                        }
                        map.setCenter(latlngbounds.getCenter());
                        map.fitBounds(latlngbounds);
                    }
                    else
                    {
                      getLocation();
                    }
                  }
                  }
              });
            }

            }

            if(action2 == 'inactive2')
            {
             action2 = 'active2';
             load_country_data2(limit2, start2);
            }
            $(window).scroll(function(){
             if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action2 == 'inactive2')
             {
              action2 = 'active2';
              // start = start + limit;
              start2 = $('#total_all_services').val();
              setTimeout(function(){
               load_country_data2(limit2, start2);
             }, 3000);
             }
            });
        }

      }
    });
});


function initialize(lat,long) {
   var myLatlng1 = new google.maps.LatLng(lat,long);

   var mapOptions = {
       zoom: 10,
       center: myLatlng1,
       mapTypeId: google.maps.MapTypeId.ROADMAP
   };
   var map = new google.maps.Map(document.getElementById('dvMap'),
   mapOptions);

   if (navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(function (position) {
           initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
           map.setCenter(initialLocation);
       });
   }
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    /*x.innerHTML = "Latitude: " + position.coords.latitude +
    "<br>Longitude: " + position.coords.longitude;*/
    initialize(position.coords.latitude,position.coords.longitude);
}

function checkpriceMinMax(current,minmax,id) {
  if(minmax == 'min')
  {
    if($('#'+id).val() != "")
    {
      if(parseInt($(current).val()) >= parseInt($('#'+id).val()))
      {
        // swal("You need to add min value from maximum value");
        swal("Warning!", "Minimum price should be less than Maximum price", "info");
        // swal("Hello world!");
        $(current).val('');
      }
    }
  }
  if(minmax == 'max')
  {
    if($('#'+id).val() != "")
    {
      if(parseInt($(current).val()) <= parseInt($('#'+id).val()))
      {
        // swal("You need to add max value from minimum value");
        swal("Warning!", "Maximum price should be greater than Minimum price", "info");
        $(current).val('');
      }
    }
  }
}

function changePosition(lat, lng){
  var myLatlng1 = new google.maps.LatLng(lat,lng);
  this.mapLoc.panTo(myLatlng1);
  this.mapLoc.setZoom(18);
}

// if(near_home_services == 0){
function initMap() {
  var map, infoWindow;
  var limit3 = 4;
  var start3 = 0;
  var action3 = 'inactive3';
  function load_country_data3(limit3, start3)
  {
  // function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: 6
    });
    infoWindow = new google.maps.InfoWindow;

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        console.log(pos);

        $.ajax({
            type: 'POST',
            url: site_url+'home/get_user_nearest_services',
            data:'lattitude='+pos.lat+'&longitude='+pos.lng+'&total_all_services='+start3,

            beforeSend: function () {
                // $('.loading').show();
            },
            success: function (data) {
              var data1 = JSON.parse(data);
              var data_servicelist = data1['services_list'];
              var data_shoplist = data1['shop_list'];
              var data_total_services = data1['total_services'];
              var all_total_services = data1['all_total_services'];
              var total_worker_service = data1['total_worker_service'];
              $('#total_all_services').val(data_total_services);
                if(data_total_services == 0){
                  var html1 =  "<p>No services found near your home</p>";
                    $('.near_home_services').html(html1);
                    $('#load_data_message').hide();
                    action3 = 'active3';

                    var markers = data_shoplist;
                    if(markers.length > 0)
                    {
                      var mapOptions = {
                        center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                        zoom: 10,
                        fullscreenControl: false,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                        mapLoc = map;
                        var infoWindow = new google.maps.InfoWindow();
                        var lat_lng = new Array();
                        var latlngbounds = new google.maps.LatLngBounds();
                        for (i = 0; i < markers.length; i++) {
                        var data = markers[i]
                        var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                        lat_lng.push(myLatlng);
                        var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: data.title
                        });
                        latlngbounds.extend(marker.position);
                        (function (marker, data) {
                        google.maps.event.addListener(marker, "click", function (e) {
                        infoWindow.setContent(data.description);
                        infoWindow.open(map, marker);
                        });
                        })(marker, data);
                        }
                        map.setCenter(latlngbounds.getCenter());
                        map.fitBounds(latlngbounds);
                    }
                    else
                    {
                      getLocation();
                    }
                }
              else{
                if(total_worker_service <= 4){
                  $('#load_data_message').hide();
                }else{
                  $('#load_data_message').show();
                  var m_url = site_url+'front/images/loader.gif';
                  $('#load_data_message').html("<img src="+m_url+">");
                  action3 = "inactive3";
                }

                if(data_total_services <= all_total_services){
                  var html =  "";
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

                    html += '<div class="col-md-6 leftbox" style="width:49%;"><div class="col-md-5"><a href="'+site_url+'detail/shop_detail/'+data_servicelist[i].encrypt_id+'"><img src="'+allimage+'" height="150px" width="200px"></a></div><div class="col-md-7"><div style="float: right;">'+rating+'</div><h3 class="cls_service_header">'+cat+'</h3><p class="cls_service_p">'+parent_cat+'<br>'+data_servicelist[i].shop_name+'</p><h2 class="cls_service_price">$'+data_servicelist[i].price+'</h2><div class="buttons"><a href="'+site_url+'appointment/appointment_step1/'+data_servicelist[i].encrypt_shop_id+'/'+data_servicelist[i].encrypt_id+'" style="color:#fff;">Book Now</a></div></div></div>';
                  }
                  $('.homeFilter').append(html);

                  // if(data_servicelist.length == 1){
                  var markers = data_shoplist;
                  if(markers.length > 0)
                  {
                    var mapOptions = {
                      center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                      zoom: 10,
                      fullscreenControl: false,
                      mapTypeId: google.maps.MapTypeId.ROADMAP
                      };
                      var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                      mapLoc = map;
                      var infoWindow = new google.maps.InfoWindow();
                      var lat_lng = new Array();
                      var latlngbounds = new google.maps.LatLngBounds();
                      for (i = 0; i < markers.length; i++) {
                      var data = markers[i]
                      var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                      lat_lng.push(myLatlng);
                      var marker = new google.maps.Marker({
                      position: myLatlng,
                      map: map,
                      title: data.title
                      });
                      latlngbounds.extend(marker.position);
                      (function (marker, data) {
                      google.maps.event.addListener(marker, "click", function (e) {
                      infoWindow.setContent(data.description);
                      infoWindow.open(map, marker);
                      });
                      })(marker, data);
                      }
                      map.setCenter(latlngbounds.getCenter());
                      map.fitBounds(latlngbounds);
                  }
                  else
                  {
                    getLocation();
                  }
                // }
                }
              }

            }
        });
      }, function() {
      });
    }
  }

  if(action3 == 'inactive3')
  {
   action3 = 'active3';
   load_country_data3(limit3, start3);
  }

  $(window).scroll(function(){
   if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action3 == 'inactive3')
   {
    action3 = 'active3';
    start3 = $('#total_all_services').val();
    setTimeout(function(){
     load_country_data3(limit3, start3);
   }, 3000);
   }
  });
  
}
// }
