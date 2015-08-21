<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOption.php';

	class FormSelectOrdenFillOption extends FormSelectOption
	{
		function __construct($parentForm , $name)
		{
			parent::__construct($parentForm , $name);
		}
	}
?>