<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormRadioLstController.php';

	class FormImgRadioLstController extends FormRadioLstController
	{
		//$this->buildNew($value)->setSrc($imgSrc)->setAlt($imgAlt)->setTitulo($titulo)
		function newOption($name , $value)
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormImgRadio.php';

			return new FormImgRadio($name , $value);
		}
	}
?>