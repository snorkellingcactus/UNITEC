<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepLabBase.php';

	class PasoA_SQLEvts_Edit extends SrvStepLabBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;


			$session=new FormSession();
			$session->autoloadLabels();
			$session->loadLabels('Latitud' , 'Longitud');

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/Laboratorio.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/updTraduccion.php';

			$lab=new Laboratorio(null , $con);

			$lab->getSQL
			(
				[
					'ID'=>FormActions::getContentID()[0]
				]
			);

			updTraduccion($session->getLabel( 'Nombre' ) , $lab->NombreID , $_SESSION['lang']);
			updTraduccion($session->getLabel( 'Direccion' ) , $lab->DireccionID , $_SESSION['lang']);

			$lab->getAsoc
			(
				[
					'Telefono'=>$session->getLabel( 'Telefono' ),
					'Enlace'=>intval
					(
						filter_var
						(
							$session->getLabel		( 'Enlace' 		) ,
							FILTER_VALIDATE_BOOLEAN
						)
					),
					'Latitud'=>$session->getLabel( 'Latitud' ),
					'Longitud'=>$session->getLabel( 'Longitud' ),
					'Mail'=>$session->getLabel( 'Mail' ),
					'Facebook'=>$session->getLabel( 'Facebook' ),
					'Twitter'=>$session->getLabel( 'Twitter' ),
					'TagID'=>nTagIfNot($session->getLabel( 'Tag' )),
					'Organigrama'=>1
				]
			);

			$lab->updSQL( false , ['ID'] );

			$this->mkUpload( 0 , $lab->ID , $session );

			$router->gotoOrigin();
			
			//return [$lab->ID];
		}
	}
?>