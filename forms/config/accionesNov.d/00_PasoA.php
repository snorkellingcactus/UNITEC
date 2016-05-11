<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepModuleCommon.php';
	
	class PasoA extends SrvStepModuleCommon
	{
		function onEdit()
		{
			parent::onEdit();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormNovEdit.php';

			$this->setLabels
			(
				new SrvFormNovEdit()
			);
		}

		function onNew()
		{
			parent::onNew();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormNovNew.php';

			$this->setLabels
			(
				new SrvFormNovNew()
			);
		}

		function buildLabelsTo($body)
		{
			$this->getHTML()->head_include('/seccs/galeria.css');

			return parent::buildLabelsTo($body);
		}
	}
?>