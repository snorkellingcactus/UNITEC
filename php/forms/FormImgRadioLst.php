<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormRadioLst.php';

	class FormImgRadioLst extends FormRadioLst
	{
		function __construct($tagName)
		{
			parent::__construct($tagName);

			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadio.php';
		}
		//$this->buildNew($value)->setSrc($imgSrc)->setAlt($imgAlt)->setTitulo($titulo)
		function newOption($name , $value)
		{
			return new FormImgRadio($name , $value);
		}
	}
?>