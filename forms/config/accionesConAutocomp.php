<?php
	if(isset($autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/getTraduccion.php';

		$padreID=fetch_all
		(
			$con->query
			(
				'	SELECT PadreID 
					FROM Secciones
					WHERE ID='.$_POST['conID']
			),
			MYSQLI_NUM
		)[0][0];
		$_POST['lleno']=fetch_all
		(
			$con->query
			(
				'	SELECT Prioridad 
					FROM Secciones
					WHERE PadreID='.$padreID.'
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
				'	SELECT Visible FROM Secciones
					WHERE ID='.$_POST['conID'].
				'	LIMIT 1'
			),
			MYSQLI_NUM
		)[0][0];
		$autocomp['Lugar']=$_POST['Orden'];

		if($_POST['Tipo']==='con')
		{
			$contenido=fetch_all
			(
				$con->query
				(
					'	SELECT ContenidoID
						FROM Secciones
						WHERE ID='.$_POST['conID']
				),
				MYSQLI_NUM
			)[0][0];
			$autocomp['Contenido']=getTraduccion($contenido , $_SESSION['lang']);
		}
		else
		{
			$autocomp['Archivo']=fetch_all
			(
				$con->query
				(
					'	SELECT ModuloID
						FROM Secciones
						WHERE ID='.$_POST['conID']
				),
				MYSQLI_NUM
			)[0][0];
		}

		echo '<pre>';
		print_r($autocomp);
		echo '</pre>';
		echo '<pre>Llenos:';
		print_r($_POST['lleno']);
		echo '</pre>';
	}
?>