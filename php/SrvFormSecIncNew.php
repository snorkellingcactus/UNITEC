<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCommonNew.php';

	class SrvFormSecIncNew extends SrvFormCommonNew
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecInc.php';
			
			return new LabelsSecInc($index);
		}
	}
?>