<?php
	$this->Url='/img/miniaturas/galeria/'.$this->ID.'.png';

	if
	(
		!empty($_SESSION['adminID']) &&
		!file_exists($_SERVER['DOCUMENT_ROOT'] . $this->Url)
	)
	{
		$this->Url='/php/genera_miniatura.php?ImgID='.$this->ID;
	}

	$clase='';
	if($this->afectado)
	{
		$clase='target';
		?>
			<span id="nImg"></span>
		<?php
	}
?>
<div class="gImg Center-Container col-xs-12 col-sm-6 col-md-4 <?php echo $clase?>">
	<?php
		if(isset($_SESSION['adminID']))
		{
			$this->formBuilder->buildActionCheckBox($this->TituloID);
		}
	?>
	<a href="imagenes.php?vRecID=<?php echo $this->ID ?>" target="_blank">
		<p>
			<?php echo $this->TituloCon ?>
			<span class="offscreen"> (se abre en nueva ventana)</span>
		</p>
		<img class="Absolute-Center" src="<?php echo $this->Url ?>" alt="<?php echo $this->AltCon ?>"/>
	</a>
	
</div>