// http://jsfiddle.net/landwire/WppF6/24/

var map;
var marker;

var sg_google_map = {};

sg_google_map.codeAddress = function () {
  sg_google_map.geocoder = new google.maps.Geocoder();
  
  var address = document.getElementById('sg-mb-map-location').value;
  sg_google_map.geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map = new google.maps.Map(document.getElementById('mapCanvas'), {
      zoom: 16,
      streetViewControl: false,
      mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
      mapTypeIds:[google.maps.MapTypeId.HYBRID, google.maps.MapTypeId.ROADMAP] 
    },
    center: results[0].geometry.location,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
      map.setCenter(results[0].geometry.location);
      marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location,
          draggable: true,
          title: 'Map Title'
      });
      sg_google_map.updateMarkerPosition(results[0].geometry.location);
      sg_google_map.geocodePosition(results[0].geometry.location);
        
      // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    sg_google_map.updateMarkerAddress('Dragging...');
  });
      
  google.maps.event.addListener(marker, 'drag', function() {
    sg_google_map.updateMarkerStatus('Dragging...');
    sg_google_map.updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    sg_google_map.updateMarkerStatus('Drag ended');
    sg_google_map.geocodePosition(marker.getPosition());
      map.panTo(marker.getPosition()); 
  });
  
  google.maps.event.addListener(map, 'click', function(e) {
    sg_google_map.updateMarkerPosition(e.latLng);
    sg_google_map.geocodePosition(marker.getPosition());
    marker.setPosition(e.latLng);
  map.panTo(marker.getPosition()); 
  }); 
  
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

sg_google_map.geocodePosition = function (pos) {
  sg_google_map.geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      sg_google_map.updateMarkerAddress(responses[0].formatted_address);
    } else {
      sg_google_map.updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

sg_google_map.updateMarkerStatus = function (str) {
  document.getElementById('markerStatus').innerHTML = str;
}

sg_google_map.updateMarkerPosition = function (latLng) {
  document.getElementById('sg-mb-map-latlen').value = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
}

sg_google_map.updateMarkerAddress = function (str) {
  document.getElementById('address').innerHTML = str;
}

jQuery(window).load(function($){
  sg_google_map.codeAddress();
});