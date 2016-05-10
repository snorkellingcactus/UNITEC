<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMenu.php';

	class LabelsMenuNew extends LabelsMenu
	{
		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';

			$this->tags->input->setValue
			(
				getLabTagTree
				(
					$_SESSION['lab']
				)
			);
		}
	}
?>