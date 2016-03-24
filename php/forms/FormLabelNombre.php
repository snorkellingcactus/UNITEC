<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelNombre extends TextBox
	{
		function __construct()
		{
			parent::__construct( 'Nombre' , 'nombre' , gettext('Nombre'));
		}
	}
?>