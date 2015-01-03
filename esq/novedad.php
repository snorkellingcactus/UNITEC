<div class="novedad col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php
		if(!empty($_SESSION['adminID']))
		{
			?>
				<input type="checkbox" class="novID" name="novID[]" form="accionesNov" value="<?php echo $esq->ID ?>"/>
			<?php
		}
	?>
	<div class="col-xs-12 col-sm-1 col-md-3 col-lg-3">
		<img src="<?php echo $esq->Imagen ?>" alt="" />
	</div>
	<h3><?php echo $esq->Titulo ?></h3>
	<p><?php echo $esq->Descripcion ?></p>
	<p class="fecha">Escrito el <?php echo $esq->Fecha ?></p>
</div>