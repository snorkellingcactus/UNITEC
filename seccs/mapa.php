<div class="clearfix"></div>

<script type="text/javascript" src="js/mapa.js"></script>
  <!-- Sacado de http://jafrancov.com/2011/12/trazar-rutas-gmaps-api-v3/ -->

<div id="map-canvas"></div>

<div id="gmapsDiag" class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
<!--    <h3>¿Cómo Llegar?</h3> -->

    <div id="panel_ruta" class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
        <button>Especificar otro origen</button>
    </div>

    <form class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <label for="modo_viaje"  class="col-xs-12 col-sm-5 col-md-5 col-lg-5">Movilidad</label>
        <select id="modo_viaje" class="opciones_ruta col-xs-12 col-sm-7 col-md-7 col-lg-7" >
            <option value="DRIVING" selected="selected">Auto</option>
            <option value="BICYCLING">Bicicleta</option>
            <option value="WALKING">Caminando</option>
        </select>

        <div class="clearfix hidden-xs"></div>

        <label for="unidad"  class="col-xs-12 col-sm-5 col-md-5 col-lg-5">Medir en</label>
        <select id="unidad"  class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <option value="METRIC" selected="selected">Metros</option>
            <option value="IMPERIAL">Imperial</option>
        </select>

        <div class="clearfix hidden-xs"></div>

        <label for="origen" class="col-xs-12 col-sm-5 col-md-5 col-lg-5">Origen</label>
        <input type="text" id="origen" placeholder="Calle, Ciudad , Estado"  class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
        <p class="gris col-xs-12 col-sm-7 col-md-7 col-offset-md-5  col-lg-7 col-offset-lg-5">Ej : Av 1 y 60, La Plata</p>
        
        <input type="button" id="buscar" value="Buscar ruta">
    </form>
</div>