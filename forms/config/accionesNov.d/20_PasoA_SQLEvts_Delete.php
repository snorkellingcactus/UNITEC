<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class PasoA_SQLEvts_Delete extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$contentID=FormActions::getContentID();

			$i=0;
			while( isset($contentID[$i]) )
			{
				$contentIDAct=$contentID[$i];

				$contenidos=fetch_all
				(
					$con->query
					(
						'	SELECT TituloID , DescripcionID
							FROM Novedades
							WHERE ID='.$contentIDAct
					),
					MYSQLI_ASSOC
				)[0];

				$con->query
				(
					'	DELETE FROM Novedades
						WHERE ID='.$contentIDAct
				);
				$con->query
				(
					'	DELETE FROM Contenidos
						WHERE ID='.$contenidos['TituloID'].'
						OR ID='.$contenidos['DescripcionID']
				);

				++$i;
			}
			
			$router->gotoOrigin();

			//$afectados[$i]=$nMenu->ContenidoID;
			//return $afectados;

		}
	}
?>