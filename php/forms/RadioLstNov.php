<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadioLst.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/RadioNov.php';

	class RadioLstNov extends FormImgRadioLst
	{
		function __construct($parentForm , $name)
		{
			parent::__construct($parentForm , $name);
		}

		function buildNew($value)
		{
			return new RadioNov($this->parentForm , $this->name , $value);
		}
	}
?>