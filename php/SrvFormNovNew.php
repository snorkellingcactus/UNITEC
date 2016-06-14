<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCommonNew.php';
	
	class SrvFormNovNew extends SrvFormCommonNew
	{
		function __construct()
		{
			parent::__construct();

			$this->setTitle( gettext(' Nueva Novedad ') );
		}
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsNovNew.php';
			
			return new LabelsNovNew($index);
		}
	}
?>