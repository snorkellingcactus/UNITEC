<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBase.php';
	
	class FirstLab extends SrvStepBase
	{
		function onSetRouter()
		{
			parent::onSetRouter();

			if( isset($_SESSION['adminID']) )
			{
				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/conexion.php';
				global $con;

				//Revisar. Workarround.
				$con->query
				(
					'	DELETE FROM Secciones
						WHERE 1
					'
				);

				include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

				$_SESSION
				[
					'ACTION'.
					(
						FormActions::FORM_ITEM_TYPE_A |
						FormActions::FORM_ACTIONS_NEW
					)
				]=true;

				$router=$this->getRouter();

				//echo '<pre>Is '.$router->getActionUrl().' IN '.$_SERVER['HTTP_REFERER'].' ?';
				//echo '</pre>';

				if
				(
					strrpos
					(
						$_SERVER['HTTP_REFERER'],
						$router->getActionUrl()
					) === false
				)
				{
					$router->redirectToStepName
					(
						'00_PasoA.php'
					);
				}
				else
				{
					$router->gotoOrigin();
				}
			}
		}
	}
?>