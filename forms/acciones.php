<form action="<?php if(isset($fAction)){echo $fAction;} ?>" method="POST" id="<?php echo $fId ?>">
	<input type="hidden" name="form" value="<?php echo $fId ?>"/>
</form>
<?php
	if(isset($_SESSION['adminID']) && $_SESSION['adminID']!==NULL)
	{
		?>
			<p class="acciones">Selecci&oacute;n:
				<input type="submit" name="elimina" value="Eliminar" form="<?php echo $fId ?>">
				<input type="submit" name="edita" value="Editar" form="<?php echo $fId ?>">
			</p>
		<?php
	}
?>