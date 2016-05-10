<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBase.php';

	class FormRadioLstController extends FormSelectController
	{
		function newOption($name , $value)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormRadio.php';
			
			return new FormRadio($name , $value);
		}
		function buildOption()
		{
			return parent::buildOption
			(
				$this->radioNames ,
				func_get_args()[0]
			);
		}
		function setRadioNames($radioNames)
		{
			$this->radioNames=$radioNames;

			return $this;
		}
	}
?>