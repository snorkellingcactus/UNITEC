<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsCalBase.php';

	class LabelsCalNew extends LabelsCalBase
	{
		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
			
			$this->labelTags->input->setValue
			(
				getLabTagTree
				(
					$_SESSION['lab']
				)
			);

			$this->visible->input->controller->setValueToSelect(1);
		}
	}
?>