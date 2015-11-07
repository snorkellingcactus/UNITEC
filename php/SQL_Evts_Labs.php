<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_List.php';

	error_reporting(-1);
	ini_set('display_errors', 'On');

	class SQL_Evts_Labs implements SQL_Evts_List
	{
		public function nuevo()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			global $con;

			$nombre=nTraduccion($_POST['Nombre'][0] , $_SESSION['lang']);
			$nombre->insSQL();
			$direccion=nTraduccion($_POST['Direccion'][0] , $_SESSION['lang']);
			$direccion->insSQL();

			$lab=new Laboratorio
			(
				[
					'Enlace'=>intVal($_POST['Enlace'][0]),
					'Latitud'=>$_POST['Latitud'][0],
					'Longitud'=>$_POST['Longitud'][0],
					'Mail'=>$_POST['Mail'][0],
					'Facebook'=>$_POST['Facebook'][0],
					'Twitter'=>$_POST['Twitter'][0],
					'TagID'=>nTagIfNot($_POST['Tag'][0]),
					'NombreID'=>$nombre->ContenidoID,
					'DireccionID'=>$direccion->ContenidoID,
					'PadreID'=>$_SESSION['conID'],
					'Organigrama'=>1
				],
				$con
			);

			$lab->insSQL();

			return [$lab->ID];
		}
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';

			global $con;

			$lab=new Laboratorio(null , $con);

			$lab->getSQL(['ID'=>$_SESSION['conID']]);

			updTraduccion($_POST['Nombre'][0] , $lab->NombreID , $_SESSION['lang']);
			updTraduccion($_POST['Direccion'][0] , $lab->DireccionID , $_SESSION['lang']);

			$lab->getAsoc
			(
				[
					'Enlace'=>intVal($_POST['Enlace'][0]),
					'Latitud'=>$_POST['Latitud'][0],
					'Longitud'=>$_POST['Longitud'][0],
					'Mail'=>$_POST['Mail'][0],
					'Facebook'=>$_POST['Facebook'][0],
					'Twitter'=>$_POST['Twitter'][0],
					'TagID'=>nTagIfNot($_POST['Tag'][0]),
					'Organigrama'=>1
				]
			);

			$lab->updSQL(false , ['ID']);
			
			return [$lab->ID];
		}
		public function elimina()
		{

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			echo '<pre>$_SESSION:';
			print_r($_SESSION);
			echo '</pre>';
			echo '<pre>$_POST:';
			print_r($_POST);
			echo '</pre>';
			$con->query
			(
				'	DELETE FROM Laboratorios
					WHERE ID='.$_SESSION['conID']
			);
		}
	}

?>