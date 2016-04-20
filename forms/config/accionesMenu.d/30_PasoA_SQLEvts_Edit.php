<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA_SQLEvts_Edit extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			echo '<pre>$_SESSION:';
			print_r($_SESSION);
			echo '</pre>';
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$contentID=FormActions::getContentID()[0];

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Menu.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';
			global $con;


			$session=new FormSession();
			$session->autoloadLabels();

			//$afectados=[];

			updTraduccion
			(
				$session->getLabel('Titulo') ,
				$contentID ,
				$_SESSION['lang']
			);

			$nMenu=new Menu();

			$nMenu->Visible=intval
			(
				filter_var
				(
					$session->getLabel('Visible') ,
					FILTER_VALIDATE_BOOLEAN
				)
			);
			//Repetido en New .
			if($session->hasLabel('Atajo'))
			{
				$nMenu->Atajo=$session->getLabel('Atajo');
			}
			if($session->hasLabel('SeccionID'))
			{
				$nMenu->SeccionID=$session->getLabel('SeccionID');
			}
			else
			{
				$nMenu->Url=$session->getLabel('Url');
			}

			$nMenu->updSQL(false , ['ContenidoID'=>$contentID]);
			$nMenu->getSQL(['ContenidoID'=>$contentID]);

			if($session->hasLabel('Tags'))
			{
				$nMenu->updTagsTargets($session->getLabel('Tags'));

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
					$session->getLabel('Tags'),
					$nMenu,
					'1',
					$session->getLabel('Lugar'),
					'ContenidoID',
					true
				);
			}

			//$afectados[$i]=$conIdAct;
			
			//return $afectados;

			//$this->router->gotoOrigin();
		}
	}
?>