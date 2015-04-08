<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<section id="con">
	<style>
		#map-canvas{min-height:500px;}
	</style>
 <div id="map-canvas"></div>
<script>
	var map;

	function initialize() {
  var mapOptions = {
    zoom: 8,
    center: new google.maps.LatLng(-34.397, 150.644)
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</section>