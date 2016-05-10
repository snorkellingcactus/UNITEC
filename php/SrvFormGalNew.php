<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';
	
	class SrvFormGalNew extends SrvStepRepeatedForm
	{
		function __construct()
		{
			parent::__construct();
		}
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsGalNew.php';
			
			return new LabelsGalNew($index);
		}
	}
?>