<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_List.php';

	class SQL_Evts_Novedades implements SQL_Evts_List
	{
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/updTraduccion.php';

			$nNov=new Novedad();
			$iMax=count($_SESSION['conID']);

			for($i=0;$i<$iMax;$i++)
			{
				$nNov->getSQL
				(
					[
						'ID'=>$_SESSION['conID'][$i]
					]
				);

				$nNov->ImagenID=$_POST['Imagen'][$i];
				$nNov->Visible=$_POST['Visible'][$i];
				$nNov->updSQL(false , ['ID']);

				updTraduccion($_POST['Descripcion'][$i] , $nNov->DescripcionID , $_SESSION['lang']);
				updTraduccion($_POST['Titulo'][$i] , $nNov->TituloID , $_SESSION['lang']);
			}
		}
		public function nuevo()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';

			$iMax=1;

			for($i=0;$i<$iMax;$i++)
			{
				$titulo=nTraduccion($_POST['Titulo'][$i] , $_SESSION['lang']);

				$descripcion=nTraduccion($_POST['Descripcion'][$i] , $_SESSION['lang']);

				$horaLoc=getdate();

				$nov=new Novedad();

				$nov->ImagenID=$_POST['Imagen'][$i];
				$nov->Fecha=$horaLoc['year'].'-'.$horaLoc['mon'].'-'.$horaLoc['mday'];

				$nov->insForanea($descripcion , 'DescripcionID' , 'ContenidoID');
				$nov->insForanea($titulo , 'TituloID' , 'ContenidoID');

				$nov->insSQL();
			}
		}
		public function elimina()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			global $con;

			$iMax=count($_SESSION['conID']);
			for($i=0;$i<$iMax;$i++)
			{
				$contenidos=$con->query('select TituloID , DescripcionID from Novedades where ID='.$_SESSION['conID'][$i]);
				$contenidos=fetch_all($contenidos , MYSQLI_ASSOC)[0];

				$con->query('delete from Novedades where ID='.$_SESSION['conID'][$i]);
				$con->query('delete from Contenidos where ID='.$contenidos['TituloID'].' or ID='.$contenidos['DescripcionID']);
			}
		}
	}

?>