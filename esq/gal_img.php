<div class="gImg col-xs-12 col-sm-6 col-md-4 col-lg-3">
	<?php
		if(isset($_SESSION['adminID']))
		{
			$this->formBuilder->buildActionCheckBox($this->TituloID);
		}
	?>
	<a href="seccs/visor.php?vRecID=<?php echo $this->ID ?>">
		<p>
			<?php echo $this->TituloCon ?>
		</p>
		<img src="<?php echo $this->Url ?>" alt="<?php echo $this->AltCon ?>" width="200" height="200" />
	</a>
	
</div>