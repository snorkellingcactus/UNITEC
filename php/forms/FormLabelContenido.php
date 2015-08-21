<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTxtAreaEditor.php';

	class FormLabelContenido extends TituloBox
	{
		public function __construct()
		{
			parent::__construct
			(
				'Contenido',
				'contenido',
				'Contenido',
				new FormTxtAreaEditor()
			);
		}
	}
?>