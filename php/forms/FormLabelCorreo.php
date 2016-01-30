<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelCorreo extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Correo' , 'correo' , gettext('Correo'));
		}
	}
?>