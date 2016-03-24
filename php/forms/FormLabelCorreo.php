<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelCorreo extends TextBox
	{
		function __construct()
		{
			parent::__construct('Correo' , 'correo' , gettext('Correo'));
		}
	}
?>