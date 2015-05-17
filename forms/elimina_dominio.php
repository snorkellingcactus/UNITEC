<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(isset($_SESSION['adminID']))
{
	$tNom='secID';
	$fNom='accionesSec';

	if($tipo===2)
	{
		$tNom='conID';
		$fNom='accionesCon';
	}
	?>
		<div class="sep"></div>
		<form method="POST" class="right" action="php/accion.php">
			<input type="hidden" name="form" value="<?php echo $fNom?>"/>
			<input type="hidden" name="<?php echo $tNom ?>" value="<?php echo $id?>"/>
			<input type="submit" name="elimina" value="Eliminar" />
			<input type="submit" name="nMenu" value="Agregar al menú" />
		</form>
	<?php
}