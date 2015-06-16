<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '//php/SQL_Evts_List.php';

	class SQL_Evts_Imagenes implements SQL_Evts_List
	{
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/elimina.php';

			$iMax=count($_SESSION['conID']);
			$afectadosLen=0;
			$afectados=[];

			for($i=0;$i<$iMax;$i++)
			{
				$nImg=new Img();

				$nImg->getSQL(['TituloID'=>$_SESSION['conID'][$i]]);

				if($nImg->Url!==$_POST['Url'])
				{
					//echo '<pre>Intentando eliminar imagen</pre>';

					elimina($_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/galeria/'.$nImg->ID.'.png' , 0775);
					elimina($_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/visor/'.$nImg->ID.'.png' , 0775);
				}

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

				$uploadOk=false;
				
				$extension=strtolower
				(
					pathinfo
					(
						$_FILES['Archivo']['name'][$i],
						PATHINFO_EXTENSION
					)
				);
				if
				(
					$extension=='png'	|| $extension=='jpg' ||
					$extension=='jpeg'	|| $extension=='gif'
				)
				{
					$uploadOk=true;
				}
				
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

				if($uploadOk)
				{
					$id=$img->ID;
					$url=$id.'.'.$extension;

					$img=new Img
					(
						[
							'ID'=>$id
						]
					);

					move_uploaded_file
					(
						$_FILES['Archivo']['tmp_name'][$i],
						$_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/tmp/'.$url
					);

					$img->updSQL(['Url'=>$url]);
				}

				$afectados[$afectadosLen]=$img->ID;
				++$afectadosLen;
			}
			return $afectados;
		}
		public function elimina()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/elimina.php';
			$iMax=count($_SESSION['conID']);

			global $con;

			for($i=0;$i<$iMax;$i++)
			{
				$imgID=fetch_all
				(
					$con->query
					(
						'	SELECT ID
							FROM Imagenes
							WHERE TituloID='.$_SESSION['conID'][$i]
					),
					MYSQLI_NUM
				)[0][0];

				elimina($_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/galeria/'.$imgID.'.png' , 0775);
				elimina($_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/visor/'.$imgID.'.png' , 0775);

				$con->query('delete from Contenidos where ID='.$_SESSION['conID'][$i]);
			}

			unset($_SESSION['conID'] , $_SESSION['form'] , $_SESSION['accion']);
		}
	}

?>