<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelTelefono extends TextBox
	{
		function __construct()
		{
			parent::__construct( 'Telefono' , 'telefono' , gettext('Teléfono'));
		}
	}
?>