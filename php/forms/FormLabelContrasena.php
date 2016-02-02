<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/PassBox.php';

	class FormLabelContrasena extends PassBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Contrasena' , 'contrasena' , gettext('Contraseña'));
		}
	}
?>