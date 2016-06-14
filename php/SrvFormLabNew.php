<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvStepRepeatedForm.php';
	
	class SrvFormLabNew extends SrvStepRepeatedForm
	{
		function __construct()
		{
			parent::__construct();

			$this->setTitle( gettext(' Nuevo Laboratorio ') );
		}
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsLabNew.php';
			
			return new LabelsLabNew($index);
		}
	}
?>