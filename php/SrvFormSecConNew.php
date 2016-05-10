<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormSecNewBase.php';

	class SrvFormSecConNew extends SrvFormSecNewBase
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecCon.php';
			
			return new LabelsSecCon($index);
		}
	}
?>