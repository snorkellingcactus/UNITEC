<?php
	if(isset($this->autocomp))
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
		include_once $_SERVER['DOCUMENT_ROOT'] . '/php/getTraduccion.php';

		global $con;

		if($_POST['Tipo']==='sec')
		{
			/*
			$this->autocomp['Titulo']=fetch_all
			(
				$con->query
				(
					'	SELECT HTMLID
						FROM Secciones
						WHERE ID='.$_POST['conID']
				),
				MYSQLI_NUM
			)[0][0];
*/
			$atajo=fetch_all
			(
				$con->query
				(
					'	SELECT Atajo
						FROM Menu
						WHERE SeccionID="'.$this->autocomp['Titulo'].'"'
				),
				MYSQLI_NUM
			);
			if(isset($atajo[0]))
			{
				$this->autocomp['Atajo']=$atajo[0][0];
			}
		}

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

			$this->autocomp['Contenido']=getTraduccion($contenido , $_SESSION['lang']);
		}
		if($_POST['Tipo']==='inc')
		{
			$this->autocomp['Archivo']=fetch_all
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

		$this->autocomp['Visible']=fetch_all
		(
			$con->query
			(
				'	SELECT Visible
					FROM Secciones
					WHERE ID='.$_POST['conID']
			),
			MYSQLI_NUM
		)[0][0];
		$this->autocomp['Lugar']=$_POST['Orden'];

		$this->autocomp['Agregar al menu']=1;
	}
?>