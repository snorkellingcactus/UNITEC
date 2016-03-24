<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTxtAreaEditor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

	class FormLabelDescripcion extends LabelBox
	{
		public function __construct()
		{
			parent::__construct
			(
				'Descripcion',
				'descripcion',
				gettext('Descripcion'),
				new FormTxtArea()
			);
		}
		function setInput($input)
		{
			parent::setInput($input);
		}
	}
?>