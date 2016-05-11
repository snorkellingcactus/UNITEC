<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';

	class SrvFormComResponse extends SrvStepRepeatedForm
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsComResponse.php';
			
			return new LabelsComResponse($index);
		}
	}
?>