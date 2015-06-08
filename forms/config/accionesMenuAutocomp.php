<?php
	if(isset($autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		$opcion=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Menu 
					WHERE ContenidoID='.$conIDAct
			),
			MYSQLI_ASSOC
		)[0];

		$autocomp['Url']=$opcion['Url'];
		$autocomp['Lenguaje']=$_SESSION['lang'];
		$autocomp['Visible']=$opcion['Visible'];
		$autocomp['Prioridad']=$opcion['Prioridad'];
		$autocomp['Titulo']=getTraduccion($opcion['ContenidoID'] , $_SESSION['lang']);
	}
?>