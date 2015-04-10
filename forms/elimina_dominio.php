<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(isset($_SESSION['adminID']))
{
	?>
		<div class="sep"></div>
		<form method="POST" class="right" action="index.php">
			<input type="hidden" name="conID" value="<?php echo $valor?>"/>
			<input type="submit" name="elimina" value="Eliminar" />
		</form>
	<?php
}