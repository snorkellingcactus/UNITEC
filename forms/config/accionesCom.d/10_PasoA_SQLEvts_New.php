<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepComBase.php';

	class PasoA_SQLEvts_New extends SrvStepComBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';

			$session=new FormSession();
			$session->loadLabel( 'RaizID' );

			//Revisar. Las novedades, imagenes, etc. pueden tener una variable de sesión
			//con nombre generalizado ( 'RaizID' ) a travez de la clase común Visor
			//en vez de ser nesesario un campo POST por cada formulario de respuesta.
			$this->setParentID( $session->getLabel('RaizID') );

			parent::setRouter($router);

			$router->gotoOrigin();
		}
	}
?>