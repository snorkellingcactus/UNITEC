<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsGalBase.php';

	class LabelsGalNew extends LabelsGalBase
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