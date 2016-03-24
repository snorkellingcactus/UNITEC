<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelDireccion extends TextBox
	{
		function __construct()
		{
			parent::__construct('Direccion' , 'direccion' , gettext('Direccion'));
		}
	}
?>