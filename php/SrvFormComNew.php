<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';

	class SrvFormComNew extends SrvStepRepeatedForm
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsComNew.php';
			
			return new LabelsComNew($index);
		}
	}
?>