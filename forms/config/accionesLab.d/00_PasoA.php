<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepModuleCommon.php';
	
	class PasoA extends SrvStepModuleCommon
	{
		function onEdit()
		{
			parent::onEdit();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormLabEdit.php';

			$this->setLabels
			(
				new SrvFormLabEdit()
			);
		}

		function onNew()
		{
			parent::onNew();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormLabNew.php';

			$this->setLabels
			(
				new SrvFormLabNew()
			);
		}
	}
?>