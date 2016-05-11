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

			$contentID=FormActions::getContentID();

			foreach( $contentID as $name=>$contentIDAct )
			{
				$con->query
				(
					'	DELETE FROM Contenidos
						WHERE ID='.$contentIDAct
				);

				echo '<pre>'.'DELETE FROM Contenidos WHERE ID='.$contentIDAct.'</pre>';
			}

			//return $_SESSION['conID'];
			$router->gotoOrigin();
		}
	}
?>