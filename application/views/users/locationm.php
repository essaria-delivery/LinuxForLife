<!--<html>-->

    
   
      <!--// This example requires the Places library. Include the libraries=places-->
      <!--// parameter when you first load the API. For example:-->
    
<!--     <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQ-YSVmQS8h0Pv3hs_YwLZ65ifZqZ23X0=places&callback=initMap" >-->
<!--    </script>-->
    
<!--    <script>-->
<!--      function initMap() {-->
<!--          alert("hii");-->
<!--        var map = new google.maps.Map(document.getElementById('map'), {-->
<!--          center: {lat: -33.8688, lng: 151.2195},-->
<!--          zoom: 13-->
<!--        });-->
<!--        var card = document.getElementById('pac-card');-->
<!--        var input = document.getElementById('pac-input');-->
<!--        var types = document.getElementById('type-selector');-->
<!--        var strictBounds = document.getElementById('strict-bounds-selector');-->

<!--        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);-->

<!--        var autocomplete = new google.maps.places.Autocomplete(input);-->

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
<!--        autocomplete.bindTo('bounds', map);-->

        // Set the data fields to return when the user selects a place.
<!--        autocomplete.setFields(-->
<!--            ['address_components', 'geometry', 'icon', 'name']);-->

<!--        var infowindow = new google.maps.InfoWindow();-->
<!--        var infowindowContent = document.getElementById('infowindow-content');-->
<!--        infowindow.setContent(infowindowContent);-->
<!--        var marker = new google.maps.Marker({-->
<!--          map: map,-->
<!--          anchorPoint: new google.maps.Point(0, -29)-->
<!--        });-->

<!--        autocomplete.addListener('place_changed', function() {-->
<!--          infowindow.close();-->
<!--          marker.setVisible(false);-->
<!--          var place = autocomplete.getPlace();-->
<!--          if (!place.geometry) {-->
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
<!--            window.alert("No details available for input: '" + place.name + "'");-->
<!--            return;-->
<!--          }-->

          // If the place has a geometry, then present it on a map.
<!--          if (place.geometry.viewport) {-->
<!--            map.fitBounds(place.geometry.viewport);-->
<!--          } else {-->
<!--            map.setCenter(place.geometry.location);-->
            map.setZoom(17);  // Why 17? Because it looks good.
<!--          }-->
<!--          marker.setPosition(place.geometry.location);-->
<!--          marker.setVisible(true);-->

<!--          var address = '';-->
<!--          if (place.address_components) {-->
<!--            address = [-->
<!--              (place.address_components[0] && place.address_components[0].short_name || ''),-->
<!--              (place.address_components[1] && place.address_components[1].short_name || ''),-->
<!--              (place.address_components[2] && place.address_components[2].short_name || '')-->
<!--            ].join(' ');-->
<!--          }-->

<!--          infowindowContent.children['place-icon'].src = place.icon;-->
<!--          infowindowContent.children['place-name'].textContent = place.name;-->
<!--          infowindowContent.children['place-address'].textContent = address;-->
<!--          infowindow.open(map, marker);-->
<!--        });-->

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
<!--        function setupClickListener(id, types) {-->
<!--          var radioButton = document.getElementById(id);-->
<!--          radioButton.addEventListener('click', function() {-->
<!--            autocomplete.setTypes(types);-->
<!--          });-->
<!--        }-->

<!--        setupClickListener('changetype-all', []);-->
<!--        setupClickListener('changetype-address', ['address']);-->
<!--        setupClickListener('changetype-establishment', ['establishment']);-->
<!--        setupClickListener('changetype-geocode', ['geocode']);-->

<!--        document.getElementById('use-strict-bounds')-->
<!--            .addEventListener('click', function() {-->
<!--              console.log('Checkbox clicked! New state=' + this.checked);-->
<!--              autocomplete.setOptions({strictBounds: this.checked});-->
<!--            });-->
<!--      }-->
<!--    </script>-->
    
        
    

    
<!--    <body>-->
<!--    <div>-->
<!--      <div  id="pac-card">-->
<!--        <input id="pac-input" type="text" placeholder="Enter a location">-->
<!--         <div id="map"></div>-->
<!--    <div id="infowindow-content">-->
<!--      <img src="" width="16" height="16" id="place-icon">-->
<!--      <span id="place-name"  class="title"></span><br>-->
<!--      <span id="place-address"></span>-->
<!--    </div>-->
			
<!--      </div>-->
<!--      </body>-->
<!--      </html>-->
<html>
/*    <style type="text/css">*/
/*    .input-controls {*/
/*      margin-top: 10px;*/
/*      border: 1px solid transparent;*/
/*      border-radius: 2px 0 0 2px;*/
/*      box-sizing: border-box;*/
/*      -moz-box-sizing: border-box;*/
/*      height: 32px;*/
/*      outline: none;*/
/*      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);*/
/*    }*/
/*    #searchInput {*/
/*      background-color: #fff;*/
/*      font-family: Roboto;*/
/*      font-size: 15px;*/
/*      font-weight: 300;*/
/*      margin-left: 12px;*/
/*      padding: 0 11px 0 13px;*/
/*      text-overflow: ellipsis;*/
/*      width: 50%;*/
/*    }*/
/*    #searchInput:focus {*/
/*      border-color: #4d90fe;*/
/*    }*/
/*</style>*/
<head>
<title>Autocomplete search address form using google map and get data into form example </title>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQ-YSVmQS8h0Pv3hs_YwLZ65ifZqZ23X0&libraries=places"></script>
</head>
<body>
 <input id="searchInput" class="input-controls" type="text" placeholder="Enter a location">
 <div class="map" id="map" style="width: 100%; height: 300px;"></div>
 <div class="form_area">
     <input type="text" name="location" id="location">
     <input type="text" name="lat" id="lat">
     <input type="text" name="lng" id="lng">
 </div>
<script>
/* script */
function initialize() {
   var latlng = new google.maps.LatLng(28.5355161,77.39102649999995);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 13
    });
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      draggable: true,
      anchorPoint: new google.maps.Point(0, -29)
   });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var geocoder = new google.maps.Geocoder();
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();   
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
  
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
       
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);          
    
        bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);
       
    });
    // this function will work on marker move event into map 
    google.maps.event.addListener(marker, 'dragend', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {        
              bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
          }
        }
        });
    });
}
function bindDataToForm(address,lat,lng){
   document.getElementById('location').value = address;
   document.getElementById('lat').value = lat;
   document.getElementById('lng').value = lng;
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</body>
</html>