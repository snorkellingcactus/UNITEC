<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_List.php';

	class SQL_Evts_Menu implements SQL_Evts_List
	{
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Menu.php';

			$iMax=count($_SESSION['conID']);
			$afectadosLen=0;
			$afectados=[];

			for($i=0;$i<$iMax;$i++)
			{
				$conIdAct=$_SESSION['conID'][$i];

				updTraduccion($_POST['Titulo'][$i] , $conIdAct , $_SESSION['lang']);

				$nMenu=new Menu
				(
					[
						'Prioridad'=>$_POST['Prioridad'][$i],
						'Url'=>$_POST['Url'][$i],
						'Visible'=>$_POST['Visible'][$i]
					]
				);

				$nMenu->updSQL(false , ['ContenidoID'=>$conIdAct]);

				$afectados[$afectadosLen]=$conIdAct;
				++$afectadosLen;
			}

			return $afectados;
		}
		public function nuevo()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Menu.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';
			global $con;

			$sMax=count($_POST['Titulo']);
			$afectadosLen=0;
			$afectados=[];

			for($s=0;$s<$sMax;$s++)
			{
				$nMenu=new Menu
				(
					[
						'Url'=>$_POST['Url'][$s],
						'Prioridad'=>$_POST['Prioridad'][$s],
						'Visible'=>$_POST['Visible'][$s],
					]
				);

				$nMenu->insForanea
				(
					nTraduccion
					(
						$_POST['Titulo'][$s],
						$_SESSION['lang']
					),
					'ContenidoID',
					'ContenidoID'
				);

				$nMenu->insSQL();

				$afectados[$afectadosLen]=$nMenu->ContenidoID;
				++$afectadosLen;
			}
			return $afectados;
		}
		public function elimina()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			global $con;

			$sMax=count($_SESSION['conID']);

			for($s=0;$s<$sMax;$s++)
			{
				$con->query
				(
					'	DELETE FROM Contenidos
						WHERE ID='.$_SESSION['conID'][$s]
				);
			}
		}
	}

?>