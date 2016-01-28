<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTxtAreaEditor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

	class FormLabelDescripcion extends LabelBox
	{
		public function __construct($parentForm)
		{
			parent::__construct
			(
				'Descripcion',
				'descripcion',
				gettext('Descripcion'),
				new FormTxtArea($parentForm)
			);
		}
		function setInput($input)
		{
			parent::setInput($input);
		}
	}
?>