<?php
	$clase='';
	if($this->afectado)
	{
		$clase='target';
		?>
			<span id="nImg"></span>
		<?php
	}
?>
<div class="gImg col-xs-12 col-sm-6 col-md-4 col-lg-3  <?php echo $clase?>">
	<?php
		if(isset($_SESSION['adminID']))
		{
			$this->formBuilder->buildActionCheckBox($this->TituloID);
		}
	?>
	<a href="imagenes.php?vRecID=<?php echo $this->ID ?>" target="_blank">
		<p>
			<?php echo $this->TituloCon ?>
		</p>
		<img src="<?php echo $this->Url ?>" alt="<?php echo $this->AltCon ?>" width="200" height="200" />
	</a>
	
</div>