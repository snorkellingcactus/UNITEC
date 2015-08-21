<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/printBool.php';
	class FormSelectBool extends FormSelect
	{
		function __construct($parentForm , $labelA , $labelB)
		{
			parent::__construct($parentForm);

			$default=false;
			$args=func_get_args();
			if(isset($args[2]))
			{
				$default=$args[2];
			}
			$this->addOption(new FormSelectOption($parentForm , $labelA , printBool($default)));
			$this->addOption(new FormSelectOption($parentForm , $labelB , printBool(!$default)));
		}
	}
?>