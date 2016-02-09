<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_List.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_ImgBase.php';

	class SQL_Evts_Labs extends SQL_Evts_ImgBase implements SQL_Evts_List
	{
		function __construct()
		{
			parent::__construct();

			$this->addResize(64 , 64 , $_SERVER['DOCUMENT_ROOT'] . '/img/logos/');
		}
		public function nuevo()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';
			global $con;

			$nombre=nTraduccion($_POST['Nombre'][0] , $_SESSION['lang']);
			$nombre->insSQL();
			$direccion=nTraduccion($_POST['Direccion'][0] , $_SESSION['lang']);
			$direccion->insSQL();

			$lab=new Laboratorio
			(
				[
					'Telefono'=>$_POST['Telefono'][0],
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

			$this->mkUpload(0 , $lab->ID);

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
					'Telefono'=>$_POST['Telefono'][0],
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

			$this->mkUpload(0 , $lab->ID);
			
			return [$lab->ID];
		}
		public function elimina()
		{

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$con->query
			(
				'	DELETE FROM Laboratorios
					WHERE ID='.$_SESSION['conID']
			);
		}
	}

?>