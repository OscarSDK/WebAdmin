<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Tracking people</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script src="https://cdn.firebase.com/js/client/2.2.3/firebase.js"></script>
    <script>
    var marker;
function initialize() {
  var myLatlng = new google.maps.LatLng(16.437310, 107.628669);
  var mapOptions = {
    zoom: 14,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Hello World!'
  });

  google.maps.event.addListener(marker, 'click', function() {
    console.log(marker.position.lat());
    marker.setPosition(new google.maps.LatLng(marker.position.lat() + 0.001, marker.position.lng()));
  });

  var fb = new Firebase("https://ride-sharing.firebaseio.com/11");
  //fb.update({ 11: "16.435077,107.631705" });

  fb.on("value", function(snapshot) {
    var latlng = snapshot.val().split(',');
      marker.setPosition(new google.maps.LatLng(latlng[0], latlng[1]));
      console.log(latlng[0] + "&" + latlng[1]);
    });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

