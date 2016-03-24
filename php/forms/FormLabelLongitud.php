<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelLongitud extends TextBox
	{
		function __construct()
		{
			parent::__construct('Longitud' , 'longitud' , gettext('Longitud'));
		}
	}
?>