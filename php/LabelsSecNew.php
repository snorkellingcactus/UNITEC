<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSec.php';

	class LabelsSecNew extends LabelsSec
	{		
		function __construct(&$index)
		{
			parent::__construct($index);
		}
	}
?>