<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBodyCommon.php';

	class PasoA extends SrvStepBodyCommon
	{
		private $session;

		function setRouter(SrvStepRouter &$router)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormSession.php';

			$this->session=new FormSession();

			$this->session->loadLabel( 'RaizID' );

			parent::setRouter( $router );
		}
		function onEdit()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormComNew.php';
			$this->setLabels
			(
				new SrvFormComNew()
			);

			$this->session->loadLabels( 'Mensaje' , 'Nombre' );

			$this->session->save();

			$this->getRouter()->redirectToStepName( '10_PasoA_SQLEvts_New.php' );
		}
		function onNew()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormComResponse.php';
			$this->setLabels
			(
				new SrvFormComResponse()
			);

			$this->setNextStepName( '30_PasoA_SQLEvts_Response.php' );

			$this->session->save();
			unset( $this->session );
		}
		function onDelete()
		{
			$session->save();

			$this->getRouter()->redirectToStepName('20_PasoA_SQLEvts_Delete.php');
		}
	}
?>