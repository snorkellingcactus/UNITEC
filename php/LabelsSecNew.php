<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsSec.php';

	class LabelsSecNew extends LabelsSec
	{
		public $aaMenu;

		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelAAMenu.php';

			$this->appendChild
			(
				$this->aaMenu=new FormLabelAAMenu()
			);
		}
	}
?>