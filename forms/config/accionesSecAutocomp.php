<?php
	if(isset($autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		$_POST['lleno']=fetch_all
		(
			$con->query
			(
				'	SELECT Prioridad 
					FROM Secciones
					WHERE PadreID IS NULL
					AND ID!='.$_POST['conID'].'
					ORDER BY Prioridad ASC
				'
			),
			MYSQLI_NUM
		);

		$autocomp['Visible']=fetch_all
		(
			$con->query
			(
				'	SELECT Visible
					FROM Secciones
					WHERE ID='.$_POST['conID']
			),
			MYSQLI_NUM
		)[0][0];
		$autocomp['Lugar']=$_POST['Orden'];
		$autocomp['Agregar al menu']=1;
		//$autocomp['Titulo']=getTraduccion($imagen['TituloID'] , $_SESSION['lang']);

		echo '<pre>';
		print_r($autocomp);
		echo '</pre>';
	}
?>