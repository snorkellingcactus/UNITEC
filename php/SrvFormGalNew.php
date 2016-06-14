<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCommonNew.php';
	
	class SrvFormGalNew extends SrvFormCommonNew
	{
		function __construct()
		{
			parent::__construct();

			$this->setTitle( gettext(' Nueva Imagen ') );
		}
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsGalNew.php';
			return new LabelsGalNew($index);
		}
	}
?>