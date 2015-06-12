<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/SQL_Evts_List.php';

	class SQL_Evts_Imagenes implements SQL_Evts_List
	{
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Img.php';

			echo '<pre>POST:';
			print_r($_POST);
			echo '</pre>';
			echo '<pre>SESSION:';
			print_r($_SESSION);
			echo '</pre>';

			$iMax=count($_SESSION['conID']);

			for($i=0;$i<$iMax;$i++)
			{
				$nImg=new Img();

				$nImg->getSQL(['TituloID'=>$_SESSION['conID'][$i]]);

				$nImg->getAsoc
				(
					[
						'Url'=>$_POST['Url'][$i],
						'Prioridad'=>$_POST['Prioridad'][$i],
						'Visible'=>$_POST['Visible'][$i],
					]
				);

				$nImg->updSQL(false , ['TituloID']);

				updTraduccion($_POST['Titulo'][$i] , $nImg->TituloID , $_SESSION['lang']);
				updTraduccion($_POST['Alt'][$i] , $nImg->AltID , $_SESSION['lang']);
			}
		}
		public function nuevo()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Img.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/Web/Pasantía/edetec/php/Foranea.php';

			$iMax=count($_POST['Titulo']);

			for($i=0;$i<$iMax;$i++)
			{
				//Creo la imagen y le asigno las propiedades.
				$img=new Img();
//				$img->Titulo=$_POST['Titulo'][$i];
				$img->Url=$_POST['Url'][$i];
				$img->Prioridad=$_POST['Prioridad'][$i];
				//$img->LenguajeID=$_POST['Lenguaje'][$i];

				$img->insForanea
				(
					nTraduccion
					(
						$_POST['Titulo'][$i],
						$_SESSION['lang']
					),
					'TituloID',
					'ContenidoID'
				);
				$img->insForanea
				(
					nTraduccion
					(
						$_POST['Alt'][$i],
						$_SESSION['lang']
					),
					'AltID',
					'ContenidoID'
				);
			
				//La inserto en la bd.
				$img->insSQL();

				//echo '<pre>';echo print_r($img);echo '</pre>';
			}
			
		}
		public function elimina()
		{
			$iMax=count($_SESSION['conID']);

			global $con;

			for($i=0;$i<$iMax;$i++)
			{
				$con->query('delete from Contenidos where ID='.$_SESSION['conID'][$i]);
			}

			unset($_SESSION['conID'] , $_SESSION['form'] , $_SESSION['accion']);
		}
	}

?>