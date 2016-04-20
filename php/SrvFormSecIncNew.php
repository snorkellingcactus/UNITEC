<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecNewBase.php';

	class SrvFormSecIncNew extends SrvFormSecNewBase
	{
		function newLabelsCollection()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecInc.php';
			
			return new LabelsSecInc();
		}
	}
?>