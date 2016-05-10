<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsLabBase.php';

	class LabelsLabNew extends LabelsLabBase
	{
		function __construct(&$index)
		{
			parent::__construct($index);

			$this->enlace->input->controller->setValueToSelect(1);
		}
	}
?>