<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMenu.php';

	class LabelsMenuNew extends LabelsMenu
	{
		function __construct(&$index)
		{
			parent::__construct($index);
		}
	}
?>