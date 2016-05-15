<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCommonNew.php';
	
	class SrvFormGalNew extends SrvFormCommonNew
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsGalNew.php';
			return new LabelsGalNew($index);
		}
	}
?>