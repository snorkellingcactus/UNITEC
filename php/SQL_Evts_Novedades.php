<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_List.php';

	class SQL_Evts_Novedades implements SQL_Evts_List
	{
		public function edita()
		{
		/*
			echo '<pre>SESSION:';
			print_r($_SESSION);
			echo '</pre>';
			echo '<pre>POST:';
			print_r($_POST);
			echo '</pre>';
		*/

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			$nNov=new Novedad();
			$iMax=count($_SESSION['conID']);
			$afectadosLen=0;
			$afectados=[];


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

				updTraduccion
				(
					$_POST['Contenido'][$i],
					$nNov->DescripcionID,
					$_SESSION['lang']
				);
				updTraduccion($_POST['Titulo'][$i] , $nNov->TituloID , $_SESSION['lang']);

				if(!empty($_POST['Tags'][$i]))
				{
					$nNov->updTagsTargets($_POST['Tags'][$i]);

					updTagsPriority
					(
						$_POST['Tags'][$i],
						$_POST['Prioridad'][$i],
						$nNov
					);
				}

				$afectados[$afectadosLen]=$nNov->TituloID;
				++$afectadosLen;
			}
			return $afectados;
		}
		public function nuevo()
		{
/*
			echo '<pre>SESSION:';
			print_r($_SESSION);
			echo '</pre>';
			echo '<pre>POST:';
			echo $_POST['Contenido'][0];
			echo '</pre>';
*/
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Novedad.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			$iMax=1;
			$afectados=[];

			for($i=0;$i<$iMax;$i++)
			{
				
				$horaLoc=getdate();

				$nov=new Novedad();

				$nov->ImagenID=$_POST['Imagen'][$i];
				$nov->Fecha=$horaLoc['year'].'-'.$horaLoc['mon'].'-'.$horaLoc['mday'];
				
				$nov->PrioridadesGrpID=nPriorityGrp();

				$nov->insForanea
				(
					nTraduccion
					(
						$_POST['Contenido'][$i]
						,
						$_SESSION['lang']
					),
					'DescripcionID',
					'ContenidoID'
				);
				$nov->insForanea
				(
					nTraduccion
					(
						$_POST['Titulo'][$i],
						$_SESSION['lang']
					),
					'TituloID',
					'ContenidoID'
				);

				$nov->insSQL();

				if(!empty($_POST['Tags'][$i]))
				{
					$nov->updTagsTargets($_POST['Tags'][$i]);
					updTagsPriority
					(
						$_POST['Tags'][$i],
						$_POST['Prioridad'][$i],
						$nov
					);
				}

				$afectados[0]=$nov->TituloID;
			}
			return $afectados;
		}
		public function elimina()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$iMax=count($_SESSION['conID']);
			for($i=0;$i<$iMax;$i++)
			{
				$contenidos=fetch_all
				(
					$con->query
					(
						'	SELECT TituloID , DescripcionID
							FROM Novedades WHERE ID='.$_SESSION['conID'][$i]
					),
					MYSQLI_ASSOC
				)[0];

				$con->query('delete from Novedades where ID='.$_SESSION['conID'][$i]);
				$con->query('delete from Contenidos where ID='.$contenidos['TituloID'].' or ID='.$contenidos['DescripcionID']);
			}
		}
	}

?>