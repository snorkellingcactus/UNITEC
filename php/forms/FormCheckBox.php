<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class FormCheckBox extends FormInput
	{
		function __construct($name , $value)
		{
			parent::__construct('checkbox');

			$this->setName($name);
			$this->setValue($value);
		}
	}
?>