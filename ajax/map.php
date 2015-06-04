<link rel="stylesheet" href="plugins/leaflet/leaflet.css" />
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div id="full-map" class="box-content fullscreenmap">
			</div>
		</div>
	</div>
</div>
<script>
listMarker = [];
// Create a function that the hub can call to broadcast messages.
chat.client.getPos = function (uid, iid, pos) {
	var latlng = pos.split('#');

	if (latlng[2] == "d") {
		if(listMarker[uid] == undefined) {
		    marker = L.marker([latlng[0], latlng[1]], {icon: myIcon}).addTo(map);

		    $.ajax({
				url: "controller/itinerary.php?act=view&map=true&itinerary_id=" + iid, // point to server-side PHP script 
		        dataType: 'text',  // what to expect back from the PHP script, if anything
		        cache: false,
		        contentType: false,
		        processData: false,      	                
		        type: 'get',
		        success: function(string){
		        	var value = $.parseJSON(string);

		            var infocontent = '<b>From:</b> ' + value['start_address'] + 
				   '<br><b>To: ' + value['end_address'] + 
				   '<br><b>Driver: </b>' + value['fullname'] + 
				   '<br><div><img src="data:image/jpeg;base64,' + value['link_avatar'] + 
				   '" style="height: 50px; width: 6 0px;"/></div><b>Distance: </b>' + 
				   value['distance'] + ' KM<br><b>Cost:</b> ' + value['cost'] + 
				   '<br><a href="controller/itinerary.php?act=view&itinerary_id=' + 
				   value['itinerary_id'] +'">View detail...</a>';

		    		marker.bindPopup(infocontent);
		        }
		    });	

		    listMarker[uid] = marker;
		} else {
		    listMarker[uid].setLatLng([latlng[0], latlng[1]]);
		    listMarker[uid].update();
		}
	}

};
$.connection.hub.start().done(function () {
	chat.server.connect("0");
});

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
	map = L.map('full-map').setView([16.06583612, 108.20202827], 11);
		L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
		maxZoom: 18
	}).addTo(map);

	myIcon = L.icon({
	 iconUrl: 'http://iconizer.net/files/Google_Maps_Icons/orig/motorbike.png',
	});
}
// Add class for fullscreen view
$('#content').addClass('full-content');
// Set height of block
SetMinBlockHeight($('.fullscreenmap'));
// Run Leaflet
LoadLeafletScript(FullScreenLeafletMap);
$(document).ready(function() {
	
});
</script>