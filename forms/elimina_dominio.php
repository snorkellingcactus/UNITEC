<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/php/is_session_started.php';
start_session_if_not();

if(isset($_SESSION['adminID']))
{
	$tNom='sec';
	$fNom='accionesSec';

	if($this->tipo===2)
	{
		$tNom='con';
		$fNom='accionesCon';
	}
	if($this->tipo===1)
	{
		$tNom='mod';
		$fNom='accionesCon';
	}
	?>
		<div class="sep"></div>
		<form method="POST" class="right" action="php/accion.php">
			<input type="hidden" name="form" value="<?php echo $fNom?>"/>
			<input type="hidden" name="conID" value="<?php echo $this->conID?>"/>
			<input type="hidden" name="Tipo" value="<?php echo $tNom ?>"/>
			<input type="hidden" name="Orden" value="<?php echo $this->orden ?>"/>
			<input type="submit" name="elimina" value="Eliminar" />
			<input type="submit" name="edita" value="Editar" />
		</form>
	<?php
}