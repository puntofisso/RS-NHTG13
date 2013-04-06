var centre_UK = new google.maps.LatLng(52.922978, -3.537598);
var london_UK = new google.maps.LatLng(51.5171, -0.1062);

var map;
var selection_marker;
var geocoder;

$(function() {
    initMap();
    initSelectionMarker();
    initGeocoder();
    initDragDetection();
});

function initMap() {
    
    var mapOptions = {
        zoom: 6,
        center: centre_UK,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
}

function initSelectionMarker() {
    selection_marker = new google.maps.Marker({
        position: london_UK,
        map: map,
        title:"Drag to select a region.",
        animation: google.maps.Animation.BOUNCE,
        draggable:true
    });
}

function initGeocoder() {
  geocoder = new google.maps.Geocoder();
}

function initDragDetection() {
    
    google.maps.event.addListener(selection_marker, 'dragend', function() {
        performGeocode(selection_marker.getPosition());
    });
}

function performGeocode(location) {
  
  geocoder.geocode( { 'latLng': location }, function(results, status) {

    $('#outputdata').html('');
    var postcode;
    if (status == google.maps.GeocoderStatus.OK) {
    
      // TODO: examine the results param, determine the appropriate region data
      // see: https://developers.google.com/maps/documentation/javascript/geocoding#GeocodingResults
      // TODO: update the text on the left to show the region selected
      // TODO: filter for an administrative_area_level_2 political type, and then just use that
      for (var i = 0; i < results.length; i++) {
        var result = results[i];
      
        var address_components = result.address_components;
        for (var j = 0; j < address_components.length; j++) {
          var address_component = address_components[j];
          
          var txt = address_component.short_name + ', ' + address_component.long_name + ':';
          for (var k = 0; k < address_component.types.length; k++) {
            var type = address_component.types[k];
            if(type=='postal_code' && address_component.types.length == 1) {
                postcode = address_component.long_name;             
            }
          }                    
        }
      }
      // make API call using postcode
      //console.log(postcode);

      var data = {
            labels : ["National Average","Local"],
            datasets : [
                {
                    fillColor : "rgba(220,220,220,0.5)",
                    strokeColor : "rgba(220,220,220,1)",
                    data : [75, 21]
                }
            ]
     };

     var options = { barShowStroke : true };

     drawHappiness('happiness', data, options);

      // set the map to show the region selected
      map.setZoom(8);
      map.panTo(location);
    } else {
      alert("Geocode was not successful for the following reason: " + status);
    }
  });
}

function drawHappiness(selector, data, options) {
    var ctx = document.getElementById(selector).getContext('2d');
    var happinessChart = new Chart(ctx).Bar(data, options);
}