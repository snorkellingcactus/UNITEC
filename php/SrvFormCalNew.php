<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCommonNew.php';
	
	class SrvFormCalNew extends SrvFormCommonNew
	{
		function __construct()
		{
			parent::__construct();

			$this->setTitle( gettext(' Nuevo Evento ') );
		}
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsCalNew.php';
			
			return new LabelsCalNew($index);
		}
	}
?>