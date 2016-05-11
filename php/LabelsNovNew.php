<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsNovBase.php';

	class LabelsNovNew extends LabelsNovBase
	{
		function __construct(&$index)
		{
			parent::__construct($index);
		}
	}
?>