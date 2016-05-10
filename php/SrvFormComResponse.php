<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepForm.php';

	class SrvFormComResponse extends SrvStepForm
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsComResponse.php';
			
			return new LabelsComResponse($index);
		}
	}
?>