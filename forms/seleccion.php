<?php
	if(isset($_SESSION['adminID']) && $_SESSION['adminID']!==NULL)
	{
		?>
		<form action="<?php if(isset($fAction)){echo $fAction;} ?>" method="POST" id="<?php echo 'reload'.$fId ?>">
			<input type="hidden" name="form" value="acciones<?php echo $fId ?>">
			<p class="acciones">Selecci&oacute;n:
				<input type="submit" name="elimina" value="Eliminar">
				<input type="submit" name="edita" value="Editar" class="disabled">
			</p>
		</form>
		<?php
	}
?>