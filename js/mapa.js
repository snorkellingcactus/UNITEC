var map;
var pos=new google.maps.LatLng(-34.90693 , -57.94290);

function initialize() 
{
  var mapOptions = 
  {
    zoom: 8,
    center: pos,
    scrollwheel:false
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

  document.getElementById('buscar').addEventListener
  (
    'click',
    solicitaRuta
  );
}

google.maps.event.addDomListener(window, 'load', initialize);

var directionsDisplay = new google.maps.DirectionsRenderer();
var directionsService = new google.maps.DirectionsService();

function solicitaRuta()
{
  var request =
  {
    origin: document.getElementById('origen').value,
    destination: pos.toString(),
    travelMode: google.maps.DirectionsTravelMode[document.getElementById('modo_viaje').value],
    unitSystem: google.maps.DirectionsUnitSystem[document.getElementById('tipo_sistema').value],
    provideRouteAlternatives: true
  };

  directionsService.route(request, trazaRuta);
}
function trazaRuta(response, status)
{
  if(status == google.maps.DirectionsStatus.OK)
  {
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("panel_ruta"));
    directionsDisplay.setDirections(response);
  }
  else 
  {
    alert("No existen rutas entre ambos puntos");
  }
}