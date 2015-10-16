<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormRadioLst.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadio.php';

	class FormImgRadioLst extends FormRadioLst
	{
		function __construct($parentForm , $name)
		{
			parent::__construct($parentForm , $name);
		}
		function addNewImgRadio($value, $imgSrc , $imgAlt)
		{
			$this->add
			(
				$this->buildNew($value)->setImgSrc($imgSrc)->setImgAlt($imgAlt)
			);

			return $this;
		}
		function buildNew($value)
		{
			return new FormImgRadio($this->parentForm , $this->name , $value);
		}
	}
?>