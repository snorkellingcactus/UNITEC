<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<section id="con">
	<style>
		#map-canvas{min-height:500px;}
	</style>
 <div id="map-canvas"></div>
<script>
	var map;

	function initialize() 
  {

    var pos=new google.maps.LatLng(-34.90693 , -57.94290);
    var mapOptions = 
    {
      zoom: 8,
      center: pos
    };
    map = new google.maps.Map( document.getElementById('map-canvas') , mapOptions );

    var marcador=new google.maps.Marker
    (
      {
        position: pos,
        map:map,
        title:'Departamento de Electrotecnia'
      }
    );

    map.setCenter(pos);
    map.setZoom(17)
  }

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</section>