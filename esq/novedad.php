<?php
	$clase='';
	if($this->afectado)
	{
		$clase='target';
		?>
			<span id="nNov"></span>
		<?php
	}

	$fechaStr=new DateTime();
	$fechaStr->createFromFormat('Y-m-d H:i:s' , $this->Fecha);

	//Extraer el orden en que debería representarse de la BD.
	$fechaStr='Escrito el '.$fechaStr->format('l').' de '.$fechaStr->format('F').' del '.$fechaStr->format('Y');
?>
<div class="novedad col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php echo $clase ?>">
	<?php
		if(!empty($_SESSION['adminID']))
		{
				$this->formBuilder->buildActionCheckBox($this->ID);
		}
	?>
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
		<img src="/img/miniaturas/galeria/<?php echo $this->ImagenID ?>.png" alt="<?php echo $this->ImagenAlt?>" />
	</div>
	<h2><?php echo $this->Titulo ?></h2>
	<p class="sangria"><?php echo $this->Descripcion ?> <a href="novedades.php?vRecID=<?php echo $this->ID?>" target="_blank">Seguir leyendo<span class="offscreen"> sobre la noticia <?php echo $this->Titulo ?> en nueva ventana</span></a></p>
	<p class="fecha"><?php echo $fechaStr ?></p>
</div>