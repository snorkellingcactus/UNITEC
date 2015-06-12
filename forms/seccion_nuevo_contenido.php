<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();

	if(isset($_SESSION['adminID']))
	{
		?>
			<form class="nCon" action="php/accion.php" method="POST" id="nCon<?php echo $this->orden?>">
			<input type="hidden" name="form" value="accionesCon">
			<input type="hidden" name="conID" value="<?php echo $this->conID?>">

			<select name="Tipo">
				<option value="con">Texto</option>
				<option value="inc">Modulo</option>
			</select>
			<input type="submit" name="nuevas" value="Nuevo">
		</form>
		<?php
	}
?>