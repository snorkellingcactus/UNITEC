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

			$contentIDAct=FormActions::getContentID()[0];

			$con->query
			(
				'	DELETE FROM Laboratorios
					WHERE ID='.$contentIDAct
			);

			if($contentIDAct === $_SESSION['lab'])
			{
				unset
				(
					$_SESSION['lab']
				);
			}

			$router->gotoOrigin();
		}
	}
?>