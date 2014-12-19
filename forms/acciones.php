<form action="#<?php if(isset($fAction)){echo $fAction;} ?>" method="POST" id="<?php echo $fId ?>"></form>
<?php
	if(isset($_SESSION['adminID']) && $_SESSION['adminID']!==NULL)
	{
		?>
			<p class="acciones">Selecci&oacute;n:
				<input type="submit" name="elimina" value="Elimina" form="<?php echo $fId ?>">
			</p>
		<?php
	}
?>