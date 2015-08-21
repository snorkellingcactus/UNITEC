<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/printBool.php';
	class FormSelectBool extends FormSelect
	{
		function __construct($labelA , $labelB)
		{
			parent::__construct();

			$default=false;
			$args=func_get_args();
			if(isset($args[2]))
			{
				$default=$args[2];
			}
			$this->addOption(new FormSelectOption($labelA , printBool($default)));
			$this->addOption(new FormSelectOption($labelB , printBool(!$default)));
		}
	}
?>