<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA_SQLEvts_New extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			$contentID=FormActions::getContentID()[0];


			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Menu.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Foranea.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			global $con;

			$session=new FormSession();
			$session->autoloadLabels();
			
			
			$nMenu=new Menu();

			$nMenu->Visible=intval
			(
				filter_var
				(
					$session->getLabel('Visible') ,
					FILTER_VALIDATE_BOOLEAN
				)
			);

			$nMenu->insForanea
			(
				nTraduccion
				(
					$session->getLabel('Titulo'),
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

			$nMenu->insSQL();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/reordena.php';

			if($session->hasLabel('Tags'))
			{
				$nMenu->updTagsTargets
				(
					$session->getLabel('Tags')
				);

				updLabsTagsPriority
				(
					$session->getLabel('Tags'),
					$nMenu,
					'1',
					$session->getLabel('Lugar'),
					'ContenidoID',
					false
				);
			}

			//$this->router->gotoOrigin();

			//$afectados[$i]=$nMenu->ContenidoID;
			//return $afectados;

		}
	}
?>