<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepForm.php';

	class SrvFormMenuNew extends SrvStepForm
	{
		function newLabelsCollection()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMenuNew.php';
			
			return new LabelsMenuNew();
		}
	}
?>