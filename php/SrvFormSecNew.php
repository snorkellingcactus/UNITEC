<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecNewBase.php';

	class SrvFormSecNew extends SrvFormSecNewBase
	{
		function newLabelsCollection()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecNew.php';
			
			return new LabelsSecNew();
		}
	}
?>