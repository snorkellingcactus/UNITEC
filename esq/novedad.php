<div class="novedad">
	<?php
		if(!empty($_SESSION['adminID']))
		{
			?>
				<input type="checkbox" class="novID" name="novID[]" form="accionesNov" value="<?php echo $esq->ID ?>"/>
			<?php
		}
	?>
	<img src="<?php echo $esq->Imagen ?>" alt=""/>
	<h3><?php echo $esq->Titulo ?></h3>
	<p><?php echo $esq->Descripcion ?></p>
</div>