var site_url = $("#site_url").val();
$(document).ready(function($) {

});

$(window).load(function() {
  	var shop_id = $("#shop_id").val();
  	var form_data = [{"name": "shop_id","value": shop_id}];
    $.ajax({
      url: site_url + 'detail/GetShops_map',
      type: "POST",
      data: form_data,
      success: function(data) {
        var markers = JSON.parse(data);
        if(markers.length > 0)
        {
            var mapOptions = {
            center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
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
