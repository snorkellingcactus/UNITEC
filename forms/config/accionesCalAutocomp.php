<?php
	if(isset($autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		$evento=fetch_all
		(
			$con->query
			(
				'	SELECT * 
					FROM Eventos 
					WHERE DescripcionID='.$conIDAct
			),
			MYSQLI_ASSOC
		)[0];

		$autocomp['Visible']=$evento['Visible'];
		$autocomp['Prioridad']=$evento['Prioridad'];
		$autocomp['Titulo']=$evento['Nombre'];
		$autocomp['Fecha']=$evento['Tiempo'];
		$autocomp['Descripcion']=getTraduccion($evento['DescripcionID'] , $_SESSION['lang']);

		//echo '<pre>Evento:';print_r($evento);echo '</pre>';
	}
?>