<link rel="stylesheet" href="plugins/leaflet/leaflet.css" />
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div id="full-map" class="box-content fullscreenmap">
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.firebase.com/js/client/2.2.3/firebase.js"></script>
<script type="text/javascript">
//
// Dynamically load  Leaflet Plugin
// homepage: http://leafletjs.com
//
function LoadLeafletScript(callback){
	if (!$.fn.L){
		$.getScript('plugins/leaflet/leaflet.js', callback);
	}
	else {
		if (callback && typeof(callback) === "function") {
			callback();
		}
	}
}

/*-------------------------------------------
	Function for Fullscreen Leaflet map page (map_leaflet.html)
---------------------------------------------*/
//
// Create Leaflet Fullscreen Map
//
function FullScreenLeafletMap(){
	var i = 0.000005;
	var map = L.map('full-map').setView([16.435077, 107.631705 ], 13);
	L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
		maxZoom: 18
	}).addTo(map);

	var myIcon = L.icon({
	    iconUrl: 'http://iconizer.net/files/Google_Maps_Icons/orig/motorbike.png',
	});

	var marker = L.marker([16.437310, 107.628669], {icon: myIcon}).addTo(map);

	map.on('click', function(e) {
	    marker.setLatLng([16.435077 + i, 107.631705]);

		marker.update();
	});

	var fb = new Firebase("https://ride-sharing.firebaseio.com/11");
	//fb.update({ 11: "16.435077,107.631705" });

	fb.on("value", function(snapshot) {
		var latlng = snapshot.val().split(',');
		// marker.setLatLng([latlng[0], latlng[1]]);
		// marker.update();
    	alert(latlng[0]);
    });
}

// Load Leaflet library and create map
function LeafletFS(){
	LoadLeafletScript(FullScreenLeafletMap);
}
$(document).ready(function() {
	// Add class for fullscreen view
	$('#content').addClass('full-content');
	// Set height of block
	SetMinBlockHeight($('.fullscreenmap'));
	// Run Leaflet
	LeafletFS();
});
</script>
