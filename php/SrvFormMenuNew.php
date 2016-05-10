<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepForm.php';

	class SrvFormMenuNew extends SrvStepForm
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMenuNew.php';
			
			return new LabelsMenuNew($index);
		}
	}
?>