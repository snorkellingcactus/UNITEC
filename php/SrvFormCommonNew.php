<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';
	
	class SrvFormCommonNew extends SrvStepRepeatedForm
	{
		function autocomplete()
		{
			parent::autocomplete();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			$this->labels->labelTags->input->setValue
			(
				getLabTagTree
				(
					$_SESSION['lab']
				)
			);

			$this->labels->visible->input->controller->setValueToSelect(1);
		}
	}
?>