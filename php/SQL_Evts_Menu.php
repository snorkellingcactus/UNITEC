<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_List.php';

	class SQL_Evts_Menu implements SQL_Evts_List
	{
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Menu.php';
/*
			echo '<pre>SESSION:';
			print_r($_SESSION);
			echo '</pre>';

			echo '<pre>POST:';
			print_r($_POST);
			echo '</pre>';
*/
			$iMax=count($_SESSION['conID']);
			for($i=0;$i<$iMax;$i++)
			{
				updTraduccion($_POST['Titulo'][$i] , $_SESSION['conID'][$i] , $_SESSION['lang']);

				$nMenu=new Menu
				(
					[
						'Prioridad'=>$_POST['Prioridad'][$i],
						'Url'=>$_POST['Url'][$i],
						'Visible'=>$_POST['Visible'][$i]
					]
				);

				$nMenu->updSQL(false , ['ContenidoID'=>$_SESSION['conID'][$i]]);
			}
		}
		public function nuevo()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Menu.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/nTraduccion.php';
			global $con;

			$sMax=count($_POST['Titulo']);

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
			}
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