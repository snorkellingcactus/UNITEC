<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/LabelsMenu.php';

	class LabelsMenuEdit extends LabelsMenu
	{
		public $hasIcon;
		
		function __construct(&$index)
		{
			parent::__construct($index);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelIcono.php';

			$this->appendChild
			(
				$this->hasIcon=new FormLabelIcono()
			);
		}
	}
?>