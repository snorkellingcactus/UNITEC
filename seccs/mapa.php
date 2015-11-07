<!-- <script type="text/javascript" src="js/mapa.js"></script> -->
<!-- Sacado de http://jafrancov.com/2011/12/trazar-rutas-gmaps-api-v3/ -->
<?php
if(isset($_SESSION['lab']))
{
    echo '<pre>Lab!';
    print_r($_SESSION['lab']);
    echo '</pre>';
}
else
{
    echo '<pre>NoLab!';
    echo '</pre>';
}
?>
<div class="contenedor">
    <img id="map-canvas" class="map-canvas" src="https://maps.googleapis.com/maps/api/staticmap?center=-34.90693 , -57.94290&zoom=17&size=500x500&maptype=roadmap
&markers=color:red%7Clabel:A%7C-34.90693 , -57.94290&key=AIzaSyAc98zfTPT0nZTSERA7bEgBdPiyI6kM6hk" alt="<?php echo gettext('Mapa de la ubicación de unitec')?>">
</div>

<div id="gmapsDiag" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 contenedor">
<!--    <h3>¿Cómo Llegar?</h3> -->

    <div id="panel_ruta" class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
        <button><?php echo gettext('Especificar otro origen')?></button>
    </div>

    <form class="col-xs-12 col-sm-12 col-md-12 col-lg-12" action="php/accion.php" method="POST">
        <label for="modo_viaje"  class="col-xs-12 col-sm-5 col-md-5 col-lg-5"><?php echo gettext('Movilidad')?></label>
        <select id="modo_viaje" name="modo_viaje" class="opciones_ruta col-xs-12 col-sm-7 col-md-7 col-lg-7" >
            <option value="DRIVING" selected="selected"><?php echo gettext('Auto')?></option>
            <option value="BICYCLING" ><?php echo gettext('Bicicleta')?></option>
            <option value="WALKING"><?php echo gettext('Caminando')?></option>
        </select>

        <div class="clearfix hidden-xs"></div>

        <label for="unidad" class="col-xs-12 col-sm-5 col-md-5 col-lg-5"><?php echo gettext('Medir en')?></label>
        <select id="unidad" name="unidad" class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <option value="METRIC" selected="selected"><?php echo gettext('Metros')?></option>
            <option value="IMPERIAL"><?php echo gettext('Imperial')?></option>
        </select>

        <div class="clearfix hidden-xs"></div>

        <label for="origen" class="col-xs-12 col-sm-5 col-md-5 col-lg-5"><?php echo gettext('Origen')?></label>
        <input type="text" id="origen" name="origen" placeholder="<?php echo gettext('Calle, Ciudad , Estado')?>"  class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
        <p class="gris col-xs-12 col-sm-7 col-md-7 col-md-offset-5 col-sm-offset-5 col-lg-7 col-lg-offset-5"><?php echo gettext('Ej : Av 1 y 60, La Plata')?></p>

        <input type="hidden" name="form" value="accionesMaps">
        <input type="submit" class="submit" id="buscar" value="<?php echo gettext('Buscar ruta')?>" name="nuevo">
    </form>
</div>