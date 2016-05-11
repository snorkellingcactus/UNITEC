<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCommonNew.php';
	
	class SrvFormNovNew extends SrvFormCommonNew
	{
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsNovNew.php';
			
			return new LabelsNovNew($index);
		}
	}
?>