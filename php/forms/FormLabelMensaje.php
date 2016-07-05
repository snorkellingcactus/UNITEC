<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTxtAreaEditor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

	class FormLabelMensaje extends LabelBox
	{
		public function __construct()
		{
			parent::__construct
			(
				'Mensaje',
				'mensaje',
				gettext('Mensaje'),
				new FormTxtArea()
			);
		}
	}
?>