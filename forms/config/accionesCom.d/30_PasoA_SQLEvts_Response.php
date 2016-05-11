<?php
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormCliRecv.php';
	//include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SQL_Evts_Secciones.php';

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepComBase.php';

	class PasoA_SQLEvts_Response extends SrvStepComBase
	{
		function setRouter(SrvStepRouter &$router)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

			echo '<pre>$_SESSION:';
			print_r
			(
				$_SESSION
			);
			echo '</pre>';

			echo '<pre>$_POST:';
			print_r
			(
				$_POST
			);
			echo '</pre>';

			//echo '<pre>Padre=$_SESSION["comConID"]</pre>';
			$this->setParentID( FormActions::getContentID()[0] );

			parent::setRouter($router);

			$router->gotoOrigin();
		}
	}
?>