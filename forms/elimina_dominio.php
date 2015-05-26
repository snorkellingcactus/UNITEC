<?php
if(session_status()===PHP_SESSION_NONE)
{
	session_start();
}
if(isset($_SESSION['adminID']))
{
	$tNom='sec';
	$fNom='accionesSec';

	if($tipo===2)
	{
		$tNom='con';
		$fNom='accionesCon';
	}
	if($tipo===1)
	{
		$tNom='mod';
		$fNom='accionesCon';
	}
	?>
		<div class="sep"></div>
		<form method="POST" class="right" action="php/accion.php">
			<input type="hidden" name="form" value="<?php echo $fNom?>"/>
			<input type="hidden" name="conID" value="<?php echo $id?>"/>
			<input type="hidden" name="Tipo" value="<?php echo $tNom ?>"/>
		<input type="hidden" name="Orden" value="<?php echo $Orden ?>"/>
			<input type="submit" name="elimina" value="Eliminar" />
			<input type="submit" name="edita" value="Editar" />
		</form>
	<?php
}