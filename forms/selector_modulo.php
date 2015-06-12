<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/conexion.php';
	global $con;

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

			<option value="<?php echo $modulo['ID']?>" 
				<?php 
					if((isset($this->autocomp[$labelName]) && $this->autocomp[$labelName]===$modulo['ID']) || (!isset($this->autocomp[$labelName]) && $m===0))
					{
						echo 'selected="selected"';
					}
				?>
			>
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