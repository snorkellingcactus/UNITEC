<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script type="text/javascript" src="js/mapa.js"></script>
	<style>
		#map-canvas{min-height:500px;}
	</style>
  <!-- Sacado de http://jafrancov.com/2011/12/trazar-rutas-gmaps-api-v3/ -->

<div id="map-canvas"></div>

<div id="gmapsDiag">
    <h3>¿Cómo Llegar?</h3>
    <div id="panel_ruta" class="col-xs-12 col-sm-12 col-md-5 col-lg-5"></div>

    <div class="clearfix visible-xs visible-sm"></div>
    
    <div class="left col-xs-12 col-sm-12 col-md-7 col-lg-7">
        <label for="modo_viaje"  class="col-xs-12 col-sm-12 col-md-6 col-lg-6">Movilidad</label>
        <select id="modo_viaje" class="opciones_ruta col-xs-12 col-sm-12 col-md-6 col-lg-6" >
            <option value="DRIVING" selected="selected">Auto</option>
            <option value="BICYCLING">Bicicleta</option>
            <option value="WALKING">Caminando</option>
        </select>

        <div class="clearfix"></div>

        <label for="unidad"  class="col-xs-12 col-sm-12 col-md-6 col-lg-6">Medir en</label>
        <select id="tipo_sistema"  class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <option value="METRIC" selected="selected">Distancia</option>
            <option value="IMPERIAL">Tiempo</option>
        </select>

        <div class="clearfix"></div>

        <label for="origen" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">Origen</label>
        <input type="text" id="origen" placeholder="Calle, Ciudad , Estado"  class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="clearfix"></div>
        <input type="button" id="buscar" value="Buscar ruta">
    </div>
</div>