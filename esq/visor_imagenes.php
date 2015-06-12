<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/actualPath.php';
	$actual=actualPath();
	$raiz=actualDir();
?>
<!-- Título -->
<h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<?php
			echo $this->TituloCon;
		?>
</h2>

<!-- Imagen y controles -->
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8 imgCont">
		<a href="<?php echo $actual ?>?vRec=<?php echo $this->vRecAnt ?>" class="flecha" title="Imagen Anterior" >
			<img src="<?php echo $raiz ?>/img/flecha_i.png" alt="Flecha hacia la izquierda"/>
		</a>

		<img src="<?php echo $this->Url ?>" alt="<?php echo $this->AltCon ?>"/>					

		<a href="<?php echo $actual ?>?vRec=<?php echo $this->vRecSig ?>"  class="flecha" title="Imagen Siguiente">
			<img src="<?php echo $raiz ?>/img/flecha_d.png" alt="Flecha hacia la derecha"/>
		</a>
</div>
<div class="clearfix"></div>