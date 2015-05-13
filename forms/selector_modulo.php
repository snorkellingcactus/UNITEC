<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';

	$modulos=$con->query('select ID , Nombre , Archivo from Modulos where PadreID is NULL');
	$modulos=fetch_all($modulos , MYSQLI_ASSOC);

	$mMax=count($modulos);

	if($mMax)
	{
		?>
			<select name="Modulo">
		<?php
	}

	for($m=0;$m<$mMax;$m++)
	{
		$modulo=$modulos[$m];
		$nombre=$modulo['Nombre'];

		if(empty($nombre))
		{
			$nombre=$modulo['Archivo'];
		}

		?>

			<option value="<?php echo $modulo['ID']?>" <?php if($m===0){echo 'selected="selected"';}?>>
				<?php echo $nombre?>
			</option>
		<?php
	}

	if($mMax)
	{
		?>
			</select>
		<?php
	}
?>