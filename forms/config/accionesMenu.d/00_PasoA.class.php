<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepModuleCommon.php';
	
	class PasoA extends SrvStepModuleCommon
	{
		function onEdit()
		{
			//$operacionStr=gettext( 'Editar opción de Menú' );

			parent::onEdit();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormMenuEdit.php';

			$this->setLabels
			(
				new SrvFormMenuEdit()
			);
		}

		function onNew()
		{
			//$operacionStr=gettext( 'Nueva opción de Menú' );

			parent::onNew();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormMenuNew.php';

			$this->setLabels
			(
				new SrvFormMenuNew()
			);
		}
	}
?>