<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Evts_List.php';

	class SQL_Evts_Imagenes implements SQL_Evts_List
	{
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Img.php';

			$iMax=count($_SESSION['conID']);
			$afectadosLen=0;
			$afectados=[];

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

				$afectados[$afectadosLen]=$nImg->ID;
				++$afectadosLen;
			}

			return $afectados;
		}
		public function nuevo()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Img.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '//php/Foranea.php';

			$iMax=count($_POST['Titulo']);
			$afectadosLen=0;
			$afectados=[];

			for($i=0;$i<$iMax;$i++)
			{
				//Creo la imagen y le asigno las propiedades.
				$img=new Img();
				$img->Url=$_POST['Url'][$i];
				$img->Prioridad=$_POST['Prioridad'][$i];

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

				$afectados[$afectadosLen]=$img->ID;
				++$afectadosLen;
			}
			return $afectados;
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