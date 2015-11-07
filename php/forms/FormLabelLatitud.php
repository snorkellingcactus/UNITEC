<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelLatitud extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Latitud' , 'latitud' , gettext('Latitud'));
		}
	}
?>