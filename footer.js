compactaLabels(document.getElementsByClassName('FormCliMail')[0]);
var map,form,rutas,volver,origen,pos,directionsDisplay,directionsService;

function inicializaGMaps()
{
  directionsDisplay = new google.maps.DirectionsRenderer();
  directionsService = new google.maps.DirectionsService();
  //pos=new google.maps.LatLng(-34.90693 , -57.94290);

  //pos=new google.maps.LatLng(-34.90693 , -57.94290);

  imagenMapa=document.getElementById('map-canvas');

  //El punto central del mapa es la ubicación del laboratorio.
  //Obtengo el centro del mapa de la URL de la imagen.
  pos=getQueryVariable
  (
    'center',
    imagenMapa.getAttribute('src').split('?')[1]
  ).split(',');

  pos=new google.maps.LatLng(pos[0] , pos[1]);

  var mapOptions = 
  {
    zoom: 8,
    center: pos,
    scrollwheel:false
  };

  padreMapa=imagenMapa.parentNode;
  padreMapa.removeChild(imagenMapa);

  imagenMapa=document.createElement('div');
  imagenMapa.setAttribute('id' , 'map-canvas');
  imagenMapa.setAttribute('class' , 'map-canvas');

  padreMapa.appendChild(imagenMapa);

  map = new google.maps.Map( imagenMapa , mapOptions );
  form=document.getElementById('gmapsDiag').getElementsByTagName('form')[0];
  rutas=document.getElementById('panel_ruta');
  volver=rutas.getElementsByTagName('button')[0];
  origen=document.getElementById('origen');

  volver.style.width='100%';
  volver.style.display='block';

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
      origen.focus();
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

    volver.focus();
  }
  else 
  {
    alert("No existen rutas entre ambos puntos");
  }
}

head.load('https://maps.googleapis.com/maps/api/js?v=3.exp&callback=inicializaGMaps');