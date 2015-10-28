<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class FormCheckBox extends FormInput
	{
		function __construct($parentForm , $name , $value)
		{
			parent::__construct($parentForm , 'checkbox');

			$this->setName($name);
			$this->setValue($value);
		}
	}
?>