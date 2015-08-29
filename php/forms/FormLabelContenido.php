<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TituloBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormTxtAreaEditor.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/ClearFix.php';

	class FormLabelContenido extends TituloBox
	{
		public function __construct($parentForm)
		{
			parent::__construct
			(
				'Contenido',
				'contenido',
				'Contenido',
				new FormTxtAreaEditor($parentForm)
			);
		}
		function setInput($input)
		{
			$this->appendChild(new ClearFix());
			
			parent::setInput($input);
		}
	}
?>