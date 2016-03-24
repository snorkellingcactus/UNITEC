<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormRadioLst.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadio.php';

	class FormImgRadioLst extends FormRadioLst
	{
		function __construct($name)
		{
			parent::__construct($name);
		}
		function addNewImgRadio($value, $imgSrc , $imgAlt , $titulo)
		{
			$this->add
			(
				$this->buildNew($value)->setSrc($imgSrc)->setAlt($imgAlt)->setTitulo($titulo)
			);

			return $this;
		}
		function buildNew($value)
		{
			return new FormImgRadio($this->name , $value);
		}
	}
?>