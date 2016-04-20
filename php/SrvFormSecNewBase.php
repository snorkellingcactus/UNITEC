<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepForm.php';
	
	class SrvFormSecNewBase extends SrvStepForm
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

			$this->labels->visible->input->setValueToSelect(1);
		}
	}
?>