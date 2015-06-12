<div class="novedad col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php
		if(!empty($_SESSION['adminID']))
		{
				$this->formBuilder->buildActionCheckBox($this->ID);
		}
	?>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<img src="<?php echo $this->Imagen ?>" alt="" />
	</div>
	<h2><?php echo $this->Titulo ?></h2>
	<p class="sangria"><?php echo $this->Descripcion ?> <a href="novedades.php?vRecID=<?php echo $this->ID?>" alt="Seguir leyendo sobre la noticia">Seguir leyendo</a></p>
	<p class="fecha">Escrito el <?php echo $this->Fecha ?></p>
</div>