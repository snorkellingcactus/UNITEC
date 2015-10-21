<?php
	$clase='';
	if($this->afectado)
	{
		$clase='target';
		?>
			<span id="targeted"></span>
		<?php
	}

	$fechaStr=new DateTime();
	$fechaStr->createFromFormat('Y-m-d H:i:s' , $this->Fecha);
	$fechaStr=$fechaStr->getTimestamp();

	//Extraer el orden en que debería representarse de la BD.
	//$fechaStr='Escrito el '.$fechaStr->format('l').' de '.$fechaStr->format('F').' del '.$fechaStr->format('Y');
	$fechaStr=sprintf(gettext('Escrito el %1$s de %2$s del %3$s') , strftime('%d' , $fechaStr) , strftime('%B' , $fechaStr) , strftime('%G' , $fechaStr));
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
	<p class="sangria"><?php echo $this->Descripcion ?> <a href="novedades.php?vRecID=<?php echo $this->ID?>" target="_blank"><?php echo _('Seguir leyendo')?><span class="offscreen"><?php echo ' '.sprintf(gettext('sobre la noticia %s en nueva ventana') , $this->Titulo)?></span></a></p>
	<p class="fecha"><?php echo $fechaStr ?></p>
</div>