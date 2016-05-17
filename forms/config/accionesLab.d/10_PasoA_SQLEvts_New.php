<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepLabBase.php';

	class PasoA_SQLEvts_New extends SrvStepLabBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);
			
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTraduccion.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$session=new FormSession();
			$session->autoloadLabels();
			$session->loadLabels( 'Latitud' , 'Longitud' );

			//$afectados=[];

			$nombre=nTraduccion
			(
				$session->getLabel( 'Nombre' ) ,
				$_SESSION['lang']
			);
			$nombre->insSQL();
			$direccion=nTraduccion
			(
				$session->getLabel( 'Direccion' ) ,
				$_SESSION['lang']
			);
			$direccion->insSQL();

			$lab=new Laboratorio
			(
				[
					'Telefono'		=>$session->getLabel			( 'Telefono' 	),
					'Enlace'		=>intval
									(
										filter_var
										(
											$session->getLabel		( 'Enlace' 		) ,
											FILTER_VALIDATE_BOOLEAN
										)
									),
					'Latitud'		=>$session->getLabel			( 'Latitud' 	),
					'Longitud'		=>$session->getLabel			( 'Longitud' 	),
					'Mail'			=>$session->getLabel			( 'Mail' 		),
					'Facebook'		=>$session->getLabel			( 'Facebook' 	),
					'Twitter'		=>$session->getLabel			( 'Twitter' 	),
					'TagID'			=>nTagIfNot($session->getLabel	( 'Tag' 		)	),
					'NombreID'		=>$nombre->ContenidoID,
					'DireccionID'	=>$direccion->ContenidoID,
					'PadreID'		=>FormActions::getContentID()[0],
					'Organigrama'	=>1
				],
				$con
			);

			$lab->insSQL();

			$this->mkUpload(0 , $lab->ID , $session);

			//return [$lab->ID];
			$router->gotoOrigin();
		}
		//$this->router->gotoOrigin();

		//$afectados[$i]=$evento->DescripcionID;
		//return $afectados;
	}
?>