<?php
	if(session_status()===PHP_SESSION_NONE)
	{
		session_start();
	}
	if(isset($_SESSION['adminID']))
	{
		?>
			<form class="nCon" action="php/accion.php" method="POST" id="nCon<?php echo $s?>">
			<input type="hidden" name="form" value="accionesCon">
			<input type="hidden" name="conID" value="<?php echo $seccion['ID']?>">

			<select name="Tipo">
				<option value="con">Texto</option>
				<option value="inc">Modulo</option>
			</select>
			<input type="submit" name="nuevas" value="Nuevo">
		</form>
		<?php
	}
?>