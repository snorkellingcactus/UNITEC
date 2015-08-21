<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectOption.php';

	class FormSelectOrdenEmptyOption extends FormSelectOption
	{
		function __construct($parentForm , $value)
		{
			parent::__construct($parentForm , '' , $value);
		}
	}
?>