<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCommonNew.php';

	//Se usa repeatedForm en vez de stepForm por problemas con OOP, para tener una base de código común.
	class SrvFormMenuNew extends SrvFormCommonNew
	{
		function __construct()
		{
			parent::__construct();

			$this->setTitle( gettext(' Nueva Opción ') );
		}

		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMenuNew.php';
			
			return new LabelsMenuNew($index);
		}
	}
?>