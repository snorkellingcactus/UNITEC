<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSec.php';

	class LabelsSecNew extends LabelsSec
	{
		public $aaMenu;

		function __construct()
		{
			parent::__construct();

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAAMenu.php';

			$this->appendChild
			(
				$this->aaMenu=new FormLabelAAMenu()
			);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/nTag.php';
/*
			$this->aaMenu->input->setValue
			(
				getLabTagTree
				(
					$_SESSION['lab']
				)
			);
*/
		}
	}
?>