<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(isset($_SESSION['adminID']))
{
	$tNom='secID';

	if($tipo===2)
	{
		$tNom='conID';
	}
	?>
		<div class="sep"></div>
		<form method="POST" class="right" action="index.php">
			<input type="hidden" name="<?php echo $tNom ?>" value="<?php echo $id?>"/>
			<input type="submit" name="elimina" value="Eliminar" />
		</form>
	<?php
}