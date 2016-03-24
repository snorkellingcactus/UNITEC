<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTxtAreaEditor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

	class FormLabelContenido extends TituloBox
	{
		public function __construct()
		{
			parent::__construct
			(
				'Contenido',
				'contenido',
				gettext('Contenido'),
				new FormTxtAreaEditor()
			);
		}
		function setInput($input)
		{
			$this->appendChild(new ClearFix());
			
			parent::setInput($input);
		}
	}
?>