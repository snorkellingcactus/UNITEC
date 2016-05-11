<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsCalBase.php';

	class LabelsCalNew extends LabelsCalBase
	{
		function __construct(&$index)
		{
			parent::__construct($index);
		}
	}
?>