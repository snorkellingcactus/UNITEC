<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelTelefono extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Telefono' , 'telefono' , gettext('Teléfono'));
		}
	}
?>