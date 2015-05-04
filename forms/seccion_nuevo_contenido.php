<?php
	if(session_status()===PHP_SESSION_NONE)
	{
		session_start();
	}
	if(isset($_SESSION['adminID']))
	{
		?>
			<form class="nCon" id="nCon<?php echo $seccion['ID'] ?>" action="php/accion.php" method="POST">
			<input type="hidden" name="form" value="accionesCon">
			<input type="hidden" name="secID" value="<?php echo $seccion['ID']?>">

			<select name="Tipo">
				<option value="con">Contenido</option>
				<option value="inc">Archivo</option>
			</select>
			<input type="submit" name="nuevas" value="Nuevo">
		</form>
		<?php
	}
?>