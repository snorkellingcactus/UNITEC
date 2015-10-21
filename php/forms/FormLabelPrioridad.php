<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelPrioridad extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Prioridad' , 'prioridad' , gettext('Prioridad'));
		}
	}
?>