<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepMenuBase.php';

	class PasoA_SQLEvts_New extends SrvStepMenuBase
	{
		function setRouter( SrvStepRouter &$router )
		{
			parent::setRouter( $router );

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Menu.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';


			global $con;

			$session=new FormSession();
			$session->loadLabels( 'FileUrl' , 'Icono' ); //¿Necesario?
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

			if($session->hasLabel('SeccionID'))
			{
				$nMenu->SeccionID=$session->getLabel( 'SeccionID' );
			}

			$nMenu->insForanea
			(
				nTraduccion
				(
					$session->getLabel( 'FileUrl' ),
					$_SESSION['lang']
				),
				'UrlIconID',
				'ContenidoID'
			);
			
			$nMenu->insForanea
			(
				nTraduccion
				(
					$session->getLabel( 'Url' ),
					$_SESSION['lang']
				),
				'UrlID',
				'ContenidoID'
			);
			
			$nMenu->insSQL();

			//Si no obtengo Menu de la BD, nMenu->ID no existe, así que usamos nMenu->ContenidoID.
			$this->mkUpload( 0 , $nMenu->ContenidoID , $session );

			if($session->hasLabel('Tags'))
			{
				$nMenu->updTagsTargets
				(
					$session->getLabel('Tags')
				);

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

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

			//$router->gotoOrigin();

			//$afectados[$i]=$nMenu->ContenidoID;
			//return $afectados;

		}
	}
?>