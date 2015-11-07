<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelLongitud extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Longitud' , 'longitud' , gettext('Longitud'));
		}
	}
?>