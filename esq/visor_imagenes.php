<?php
	$actual=basename($_SERVER['SCRIPT_FILENAME']);
?>
<!-- Título -->
<h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<?php
		echo htmlentities($this->TituloCon);

		/*
			<a href="<?php echo $actual ?>?vRec=<?php echo $this->vRecSig ?>"  class="flecha" title="Imagen Siguiente">
				<img src="/img/flecha_d.png" alt="Flecha hacia la derecha"/>
			</a>
		*/
	?>
</h2>

<!-- Imagen y controles -->
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8 imgCont">
		<img src="/img/miniaturas/visor/<?php echo $this->ID ?>.png" alt="<?php echo htmlentities($this->AltCon) ?>"/>
		<?php
			if(!$this->isFirst)
			{
				?>
					<img src="/img/miniaturas/visor/<?php echo $this->IDAnt ?>.png" alt="<?php echo htmlentities($this->AltConAnt) ?>" class="anterior"/>
				<?php
			}
		?>
</div>
<div class="clearfix"></div>