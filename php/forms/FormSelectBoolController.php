<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectController.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/printBool.php';

	class FormSelectBoolController extends FormSelectController
	{
		public function trySelect($value)
		{
			return parent::trySelect
			(
				printBool
				(
					$value
				)
			);
		}
		public function buildOption()
		{
			$args=func_get_args();

			return parent::buildOption
			(
				$args[0] ,
				printBool
				(
					$args[1]
				)
			);
		}
	}
?>