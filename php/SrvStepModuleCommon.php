<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepBodyCommon.php';
	
	class SrvStepModuleCommon extends SrvStepBodyCommon
	{
		function onEdit()
		{
			$this->setNextStepName( '30_PasoA_SQLEvts_Edit.php' );
		}

		function onNew()
		{
			$this->setNextStepName( '10_PasoA_SQLEvts_New.php' );
		}

		function onDelete()
		{
			$this->getRouter()->redirectToStepName( '20_PasoA_SQLEvts_Delete.php' );
		}
	}
?>