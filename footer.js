compactaLabels(document.getElementsByClassName('FormCliMail')[0]);
var map,form,rutas,volver,origen,pos,directionsDisplay,directionsService, marcadorA;

function inicializaGMaps()
{
  directionsDisplay = new google.maps.DirectionsRenderer
  (
    {
      'suppressMarkers':true
    }
  );
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

  window.console.log('Pos:');
  window.console.log(pos);

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
  imagenMapa.style.height='400px';

  padreMapa.appendChild(imagenMapa);

  map = new google.maps.Map( imagenMapa , mapOptions );
  form=document.getElementById('gmapsDiag').getElementsByTagName('form')[0];
  rutas=document.getElementById('panel_ruta');
  volver=rutas.getElementsByTagName('button')[0];
  origen=document.getElementById('origen0');

  volver.style.width='100%';
  volver.style.display='block';

  initialMapDiagHidden(rutas);
  initialMapDiagShowed(form);

  //Revisar. Internacionalizar.
  marcadorA=new google.maps.Marker
  (
    {
      position: pos,
      map:map,
      icon:'https://mts.googleapis.com/maps/vt/icon/name=icons/spotlight/spotlight-waypoint-b.png&text=B&psize=16&font=fonts/Roboto-Regular.ttf&color=ff333333&ax=44&ay=48&scale=1',
      title:'Departamento de Electrotecnia'
    }
  );
  marcadorB=new google.maps.Marker
  (
    {
      icon:'https://mts.googleapis.com/maps/vt/icon/name=icons/spotlight/spotlight-waypoint-a.png&text=A&psize=16&font=fonts/Roboto-Regular.ttf&color=ff333333&ax=44&ay=48&scale=1'
/*
      new google.maps.Icon
      (
        '/img/marcadorA.png'
      )
*/
    }
  );

  map.setCenter(pos);
  map.setZoom(17);

  volver.addEventListener
  (
    'click',
    function()
    {
      window.console.log('hello!');
      animationStartShow(form);
      animationStartHide(rutas);
      origen.focus();
    }
  );
  document.getElementById('buscar0').addEventListener
  (
    'click',
      solicitaRuta
  );
  document.getElementById('origen0').addEventListener
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
      origin: document.getElementById('origen0').value,
      destination: pos,
      travelMode: google.maps.DirectionsTravelMode[document.getElementById('modo_viaje0').value],
      unitSystem: google.maps.DirectionsUnitSystem[document.getElementById('unidad0').value],
      provideRouteAlternatives: true
    };

    window.console.log('Consulta:');
    window.console.log(request);

    directionsService.route(request, trazaRuta);
  }
}
function trazaRuta(response, status)
{
  window.console.log('Respuesta:');
  window.console.log(status);

  if(status == google.maps.DirectionsStatus.OK)
  {
/*
    if(marcador !== false)
    {
      marcador.setMap(null);
      marcador=false;
    }
*/
    animationStartShow(rutas);
    animationStartHide(form);

    volver.focus();

    window.console.log(response);
    var overview_path=startLoc=response.routes[0].overview_path[0];

/*
  (
    {
      position: new google.maps.LatLng( startLoc.lat() , startLoc.lng() ),
      map:map
    }
  );
*/

    marcadorB.setPosition
    (
      new google.maps.LatLng
      (
        startLoc.lat() ,
        startLoc.lng()
      )
    );
    marcadorB.setTitle( response.request.origin );
    marcadorB.setMap( null );

    directionsDisplay.setMap( map );
    directionsDisplay.setPanel( document.getElementById("panel_ruta") );
    directionsDisplay.setDirections( response );

    marcadorB.setMap( map );
  }
  else 
  {
    alert
    (
      "No existen rutas entre ambos puntos"
    );
  }
}

head.load( 'https://maps.googleapis.com/maps/api/js?v=3.exp&callback=inicializaGMaps' );