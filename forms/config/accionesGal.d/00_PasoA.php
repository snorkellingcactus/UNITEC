<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepModuleCommon.php';
	
	class PasoA extends SrvStepModuleCommon
	{
		function onEdit()
		{
			parent::onEdit();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormGalEdit.php';

			$this->setLabels
			(
				new SrvFormGalEdit()
			);
		}

		function onNew()
		{
			parent::onNew();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormGalNew.php';

			$this->setLabels
			(
				new SrvFormGalNew()
			);
		}
	}
?>