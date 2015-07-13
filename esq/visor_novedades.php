<section class="novedades col-lg-10 col-md-10 col-sm-10 col-xs-10">
	<!-- Imagen -->
	<img alt="<?php echo $this->ImagenAlt?>" src="/img/miniaturas/visor/<?php echo $this->ImagenID?>.png" class="shadow col-xs-12 col-sm-5 col-md-5 col-lg-5">

	<!-- Título -->
	<h1>
			<?php echo $this->TituloCon ?>
	</h1>
	<p class="sangria">
		<?php echo html_entity_decode($this->DescripcionCon);?>
	</p>
</section>
<div class="clearfix"></div>