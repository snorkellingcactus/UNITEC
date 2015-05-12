<?php
	if(isset($autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		$novedad=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Novedades 
					WHERE ID='.$conIDAct
			),
			MYSQLI_ASSOC
		)[0];

		$autocomp['Visible']=$novedad['Visible'];
		$autocomp['Prioridad']=$novedad['Prioridad'];
		$autocomp['Imagen']=$novedad['ImagenID'];
		$autocomp['Descripcion']=getTraduccion($novedad['DescripcionID'] , $_SESSION['lang']);
		$autocomp['Titulo']=getTraduccion($novedad['TituloID'] , $_SESSION['lang']);

		echo '<pre>';
		print_r($autocomp);
		echo '</pre>';
	}
?>