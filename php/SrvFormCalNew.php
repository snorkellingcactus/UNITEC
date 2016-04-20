<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';
	
	class SrvFormCalNew extends SrvStepRepeatedForm
	{
		function newLabelsCollection()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsCalNew.php';
			
			return new LabelsCalNew();
		}
	}
?>