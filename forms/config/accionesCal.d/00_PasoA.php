<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepModuleCommon.php';
	
	class PasoA extends SrvStepModuleCommon
	{
		function onEdit()
		{
			parent::onEdit();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCalEdit.php';

			$this->setLabels
			(
				new SrvFormCalEdit()
			);
		}

		function onNew()
		{
			parent::onNew();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCalNew.php';

			$this->setLabels
			(
				new SrvFormCalNew()
			);
		}
	}
?>