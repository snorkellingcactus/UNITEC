<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';

	class Elimina extends SrvStepBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			parent::setRouter($router);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
			global $con;

			$action=FormActions::checkActionIn($_POST);

			if($action===false)
			{
				$action=FormActions::checkActionIn($_SESSION);
			}

			$contentID=FormActions::getContentID()[0];

			if($action & FormActions::FORM_ITEM_TYPE_B)
			{
				$contenidoID=fetch_all
				(
					$con->query('SELECT ContenidoID FROM Secciones WHERE ID='.$contentID),
					MYSQLI_NUM
				)[0][0];

				if($contenidoID!==NULL)
				{
					/*
						Existe una relacion ON DELETE CASCADE entre las tablas 
						Secciones->ContenidoID y Traducciones->ContenidoID, de manera
						que eliminando el contenido, automáticamente se elimina la sección
						y las traducciones relacionadas.
					*/
						
					$jj=$con->query('DELETE FROM Contenidos WHERE ID='.$contenidoID);

					$contentID=false;
				}
			}

			if($contentID!==false)
			{
				/*	
					Existe una relación ON DELETE CASCADE entre Secciones->PadreID
					y Secciones->ID, de manera tal que al eliminar una seccion
					se eliminan las secciones hijas.
				*/

				$con->query('DELETE FROM Secciones WHERE ID='.$contentID);
			}

			$router->gotoOrigin();
		}
	}
?>