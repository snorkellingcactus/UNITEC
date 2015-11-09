<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_List.php';

	class SQL_Evts_Imagenes implements SQL_Evts_List
	{
		//$_FILES['File']['name'][$i]
		//
		public function mkUrlArchivo($img , $name , $tmpName)
		{
			$uploadOk=false;
				
			$extension=strtolower
			(
				pathinfo
				(
					$name,
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

			if($uploadOk)
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/phpthumb/ThumbLib.inc.php';
				
				$thumb=PhpThumbFactory::create($tmpName , ['resizeUp'=>true]);

				$thumb->resize(800 , 600)->save($_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/visor/'.$img->ID.'.png');
				$thumb->resize(280 , 210)->save($_SERVER['DOCUMENT_ROOT'] . '/img/miniaturas/galeria/'.$img->ID.'.png');

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/elimina.php';

				elimina($tmpName , 0755);
			}
		}
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

				if($nImg->Url!=='/img/miniaturas/galeria/'.$_POST['Url'][$i])
				{
					//echo '<pre>Intentando eliminar imagen</pre>';
					//$nImg->Fecha=date("Y-m-d H:i:s");

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

				$this->mkUrlArchivo
				(
					$nImg ,
					$_FILES['File']['name'][$i],
					$_FILES['File']['tmp_name'][$i]
				);
				if(!empty($_POST['Tags'][$i]))
				{
					$nImg->updTagsTargets($_POST['Tags'][$i]);
				}

				$afectados[$afectadosLen]=$nImg->ID;

				++$afectadosLen;
			}

			return $afectados;
		}
		public function nuevo()
		{
			echo '<pre>FILES:';
			print_r($_FILES);
			echo '</pre>';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Img.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';

			$iMax=count($_POST['Titulo']);
			$afectadosLen=0;
			$afectados=[];

			for($i=0;$i<$iMax;$i++)
			{
				if
				(
					empty($_POST['Titulo'][$i]) ||
					(
						empty($_POST['Url'][$i]) &&
						empty($_FILES['File']['name'][$i])
					)
				)
				{
					continue;
				}
				$img=new Img
				(
					[
						'Url'=>$_POST['Url'][$i],
						'Prioridad'=>$_POST['Prioridad'][$i]
					]
				);

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

				if(!empty($_POST['Tags'][$i]))
				{
					$nImg->updTagsTargets($_POST['Tags'][$i]);
				}

				if(!empty($_FILES['File']['name'][$i]))
				{
					$this->mkUrlArchivo
					(
						$img ,
						$_FILES['File']['name'][$i],
						$_FILES['File']['tmp_name'][$i]
					);
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