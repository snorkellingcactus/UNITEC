<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepForm.php';

	class SrvFormComNew extends SrvStepForm
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsComNew.php';
			
			return new LabelsComNew($index);
		}
	}
?>