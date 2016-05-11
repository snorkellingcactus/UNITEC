<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA_SQLEvts_Delete extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$con->query
			(
				'	DELETE FROM Laboratorios
					WHERE ID='.FormActions::getContentID()[0]
			);

			$router->gotoOrigin();
		}
	}
?>