<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';

	class FormSelectLabel extends LabelBox
	{
		function __construct($parentForm, $name , $id , $labelText)
		{
			parent::__construct
			(
				$name,
				$id,
				$labelText,
				new FormSelect($parentForm)	
			);
		}
		function addOption($name , $value)
		{
			$this->input->addOption
			(
				$this->input->buildOption($name , $value)
			);
		}
	}
?>