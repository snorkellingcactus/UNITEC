<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/SrvFormCommonNew.php';

	class SrvFormSecNew extends SrvFormCommonNew
	{
		function __construct()
		{
			parent::__construct();

			$this->setTitle( gettext(' Nueva sección ') );
		}
		function newLabelsCollection(&$index)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSecNew.php';
			
			return new LabelsSecNew($index);
		}
	}
?>