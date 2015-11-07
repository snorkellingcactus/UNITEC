<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelNombre extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Nombre' , 'nombre' , gettext('Nombre'));
		}
	}
?>