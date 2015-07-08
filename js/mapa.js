var map,form,rutas,volver,pos,directionsDisplay,directionsService;

function cargaGMaps()
{
  var script=document.createElement('script');
      script.setAttribute('type','text/javascript');
      script.setAttribute('src','https://maps.googleapis.com/maps/api/js?v=3.exp&callback=inicializaGMaps');

      document.body.appendChild(script);
}
function inicializaGMaps()
{
  directionsDisplay = new google.maps.DirectionsRenderer();
  directionsService = new google.maps.DirectionsService();
  pos=new google.maps.LatLng(-34.90693 , -57.94290);

  var mapOptions = 
  {
    zoom: 8,
    center: pos,
    scrollwheel:false
  };

  map = new google.maps.Map( document.getElementById('map-canvas') , mapOptions );
  form=document.getElementById('gmapsDiag').getElementsByTagName('form')[0];
  rutas=document.getElementById('panel_ruta');
  volver=rutas.getElementsByTagName('button')[0];

  volver.style.width='100%';
  initialMapDiagHidden(rutas);
  initialMapDiagShowed(form);

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

  volver.addEventListener
  (
    'click',
    function()
    {
      animationStartShow(form);
      animationStartHide(rutas);
    }
  );
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

function setMapDiagStyles(ele , opacity , zIndex , position , display)
{
  ele.style.opacity=opacity;
  ele.style.zIndex=zIndex;
  ele.style.position=position;
  ele.style.display=display;
}
function initialMapDiagHidden(ele)
{
  setMapDiagStyles(ele , 0 , 1 , 'absolute' , 'none')
}
function initialMapDiagShowed(ele)
{
  setMapDiagStyles(ele , 1 , 10 , 'static' , 'block');
}
function animationStartHide(ele)
{
  ele.addEventListener('animationend' , animationEndHide);
  ele.style.display="block";
  ele.classList.add('esconde');
}
function animationStartShow(ele)
{
  ele.addEventListener('animationend' , animationEndShow);
  ele.style.display="block";
  ele.classList.add('aparece');
}
function animationEndHide()
{
  initialMapDiagHidden(this);
  this.classList.remove('esconde');
  this.removeEventListener('animationend' , animationEndHide);
}
function animationEndShow()
{
  initialMapDiagShowed(this);
  this.classList.remove('aparece');
  this.removeEventListener('animationEnd' , animationEndShow);
}
function solicitaRuta(event)
{
  if
  (
    (event.type=='keypress' && event.keyCode===13) ||
    event.type==='click'
  )
  {
    event.preventDefault();
    event.cancelBubble=1;

    var request =
    {
      origin: document.getElementById('origen').value,
      destination: pos.toString(),
      travelMode: google.maps.DirectionsTravelMode[document.getElementById('modo_viaje').value],
      unitSystem: google.maps.DirectionsUnitSystem[document.getElementById('unidad').value],
      provideRouteAlternatives: true
    };

    directionsService.route(request, trazaRuta);
  }
}
function trazaRuta(response, status)
{
  if(status == google.maps.DirectionsStatus.OK)
  {
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("panel_ruta"));
    directionsDisplay.setDirections(response);

    animationStartShow(rutas);
    animationStartHide(form);
  }
  else 
  {
    alert("No existen rutas entre ambos puntos");
  }
}
cargaGMaps();