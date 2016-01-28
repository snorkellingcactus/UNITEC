<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_List.php';

	ini_set('display_errors', 'On');

	class SQL_Evts_Labs implements SQL_Evts_List
	{
		public function upload($labID)
		{
			//empty solo acepta variables.
			$trimStr=trim($_FILES['File']['name'][0]);

			if
			(
				!empty
				(
					$trimStr
				)
			)
			{
				$this->mkUrlArchivo
				(
					$labID ,
					$_FILES['File']['name'][0],
					$_FILES['File']['tmp_name'][0]
				);
			}
		}
		public function mkUrlArchivo($labID , $name , $tmpName)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/uploadImgOk.php';
			
			if(uploadImgOk($name))
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/phpthumb/ThumbLib.inc.php';
				
				$thumb=PhpThumbFactory::create($tmpName , ['resizeUp'=>true]);

				$thumb->resize(64 , 64)->save($_SERVER['DOCUMENT_ROOT'] . '/img/logos/'.$labID.'.png');

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/elimina.php';

				elimina($tmpName , 0755);
			}
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

			$this->upload($lab->ID);

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

			$this->upload($lab->ID);
			
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