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

				$this->getRouter()->redirectToStepName
				(
					'00_PasoA.php'
				);
			}
		}
	}
?>