<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_List.php';

	class SQL_Evts_Menu implements SQL_Evts_List
	{
		public function edita()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Menu.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
			global $con;

			$_SESSION['conID']=[$_SESSION['conID']];

			$iMax=count($_SESSION['conID']);
			$afectadosLen=0;
			$afectados=[];

			for($i=0;$i<$iMax;$i++)
			{
				$conIdAct=$_SESSION['conID'][$i];

				updTraduccion($_POST['Titulo'][$i] , $conIdAct , $_SESSION['lang']);

				$nMenu=new Menu();

				$nMenu->getAsoc
				(
					[
						'Url'=>$_POST['Url'][$i],
						'Visible'=>$_POST['Visible'][$i]
					]
				);

				$nMenu->updSQL(false , ['ContenidoID'=>$conIdAct]);
				$nMenu->getSQL(['ContenidoID'=>$conIdAct]);

				if(!empty($_POST['Tags'][$i]))
				{
					$nMenu->updTagsTargets($_POST['Tags'][$i]);

					$nMenu->PrioridadesGrpID=fetch_all
					(
						$con->query
						(
							'	SELECT PrioridadesGrpID
								FROM Menu
								WHERE ID='.$nMenu->ID
						),
						MYSQLI_NUM
					)[0][0];

					updLabsTagsPriority
					(
						$_POST['Tags'][$i],
						$nMenu,
						'1',
						$_POST['Lugar'][$i],
						'ContenidoID',
						true
					);
/*
					if(isTagInSQLObj($_POST['Tags'][$i] , $nMenu))
					{
						if(!hasSQLObjPriority($nMenu , $_SESSION['lab']))
						{
							insertSQLObjPriority
							(
								$nMenu->PrioridadesGrpID,
								$_SESSION['lab'],
								reordena
								(
									$_POST['Lugar'][0],
									$nMenu,
									'1',
									'ContenidoID',
									false,
									false
								)
							);
						}
						else
						{
							updSQLObjPriority
							(
								$nMenu->PrioridadesGrpID,
								$_SESSION['lab'],
								reordena
								(
									$_POST['Lugar'][0],
									$nMenu,
									'1',
									'ContenidoID',
									$_SESSION['conID'][$i],
									true
								)
							);
						}
					}
*/
				}

				$afectados[$afectadosLen]=$conIdAct;
				++$afectadosLen;
			}
			die();
			return $afectados;
		}
		public function nuevo()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Menu.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			global $con;

			//$_SESSION['conID']=[$_SESSION['conID']];

			$sMax=count($_POST['Titulo']);
			$afectadosLen=0;
			$afectados=[];

			for($s=0;$s<$sMax;$s++)
			{
				$nMenu=new Menu
				(
					[
						'Url'=>$_POST['Url'][$s],
						'Visible'=>$_POST['Visible'][$s]
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
				$con->query
				(
					'	INSERT INTO PrioridadesGrp()
						VALUES()
					'
				);
				$nMenu->PrioridadesGrpID=$con->insert_id;

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

				$nMenu->insSQL();

				if(!empty($_POST['Tags'][$s]))
				{
					$nMenu->updTagsTargets($_POST['Tags'][$s]);;

					updLabsTagsPriority
					(
						$_POST['Tags'][$s],
						$nMenu,
						'1',
						$_POST['Lugar'][$s],
						'ContenidoID',
						false
					);
				}

				$afectados[$afectadosLen]=$nMenu->ContenidoID;
				++$afectadosLen;
			}
			return $afectados;
		}
		public function elimina()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$_SESSION['conID']=[$_SESSION['conID']];

			$sMax=count($_SESSION['conID']);

			for($s=0;$s<$sMax;$s++)
			{
				$con->query
				(
					'	DELETE FROM Contenidos
						WHERE ID='.$_SESSION['conID'][$s]
				);

				//echo '<pre>';print_r('	DELETE FROM Contenidos WHERE ID='.$_SESSION['conID'][$s]);echo '</pre>';
			}
		}
	}

?>