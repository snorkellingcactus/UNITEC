<?php
	if(isset($autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		$imagen=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Imagenes 
					WHERE TituloID='.$conIDAct
			),
			MYSQLI_ASSOC
		)[0];

		
		echo '<pre>Imagen: ';
		print_r($imagen);
		echo '</pre>';

		$autocomp['Url']=$imagen['Url'];
		$autocomp['Visible']=$imagen['Visible'];
		$autocomp['Prioridad']=$imagen['Prioridad'];
		$autocomp['Titulo']=getTraduccion($imagen['TituloID'] , $imagen['LenguajeID']);

		echo '<pre>';
		print_r($autocomp);
		echo '</pre>';
	}
?>