<?php
	$this->Url='/img/miniaturas/galeria/'.$this->ID.'.png';
/*
	if
	(
		!empty($_SESSION['adminID']) &&
		!file_exists($_SERVER['DOCUMENT_ROOT'] . $this->Url)
	)
	{
		$this->Url='/php/genera_miniatura.php?ImgID='.$this->ID;
	}
*/
	$clase='';
	if($this->afectado)
	{
		$clase='target';
		?>
			<span id="targeted"></span>
		<?php
	}
?>
<div class="gImg Center-Container col-xs-12 col-sm-6 col-md-4 <?php echo $clase?>">
	<?php
		if(isset($_SESSION['adminID']))
		{
			echo $this->formBuilder->buildActionCheckBox($this->TituloID)->getHTML();
		}
	?>
	<a href="<?php echo substr(getenv('LANG'), 0 , 2).'/espacios/'.$this->lName.'/galeria/'.$this->Fecha.'/'.urlencode($this->TituloCon).'-'.$this->ID ?>" target="_blank">
		<p>
			<?php echo htmlentities($this->TituloCon) ?>
			<span class="offscreen"><?php echo ' '.gettext('(se abre en nueva ventana)')?></span>
		</p>
		<img class="Absolute-Center" src="<?php echo htmlentities($this->Url) ?>" alt="<?php echo htmlentities($this->AltCon) ?>"/>
	</a>
	
</div>