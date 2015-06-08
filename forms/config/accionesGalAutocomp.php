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

		$autocomp['Url']=$imagen['Url'];
		$autocomp['Visible']=$imagen['Visible'];
		$autocomp['Prioridad']=$imagen['Prioridad'];
		$autocomp['Titulo']=getTraduccion($imagen['TituloID'] , $_SESSION['lang']);
	}
?>