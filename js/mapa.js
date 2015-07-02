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
  document.getElementById('origen').addEventListener
  (
    'keypress',
    solicitaRuta
  );
}

google.maps.event.addDomListener(window, 'load', initialize);

var directionsDisplay = new google.maps.DirectionsRenderer();
var directionsService = new google.maps.DirectionsService();

function solicitaRuta(event)
{
  if
  (
    (event.type=='keypress' && event.keyCode===13) ||
    event.type==='click'
  )
  {
    var request =
    {
      origin: document.getElementById('origen').value,
      destination: pos.toString(),
      travelMode: google.maps.DirectionsTravelMode[document.getElementById('modo_viaje').value],
      unitSystem: google.maps.DirectionsUnitSystem[document.getElementById('unidad').value],
      provideRouteAlternatives: true
    };

    directionsService.route(request, trazaRuta);

    var form=document.getElementById('gmapsDiag').getElementsByTagName('form')[0];

    form.classList.add('esconde');
    form.addEventListener
    (
      'animationend',
      function()
      {
        this.style.opacity=0;
        this.style.zIndex=1;
      }
    );

  }
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