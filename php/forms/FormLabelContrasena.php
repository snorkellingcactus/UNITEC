<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/PassBox.php';

	class FormLabelContrasena extends PassBox
	{
		function __construct()
		{
			parent::__construct('Contrasena' , 'contrasena' , gettext('Contraseña'));
		}
	}
?>