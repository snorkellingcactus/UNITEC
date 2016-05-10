<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBase.php';

	class FormRadioLst extends FormSelectBase
	{
		function __construct($tagName)
		{
			parent::__construct($tagName);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormRadio.php';
		}
		function newOption($name , $value)
		{
			return new FormRadio($name , $value);
		}
		function buildOption()
		{
			return parent::buildOption
			(
				$this->getName() ,
				func_get_args()[0]
			);
		}
	}
?>