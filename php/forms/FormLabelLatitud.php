<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelLatitud extends TextBox
	{
		function __construct()
		{
			parent::__construct('Latitud' , 'latitud' , gettext('Latitud'));
		}
	}
?>