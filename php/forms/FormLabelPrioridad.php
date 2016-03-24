<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelPrioridad extends TextBox
	{
		function __construct()
		{
			parent::__construct( 'Prioridad' , 'prioridad' , gettext('Prioridad'));
		}
	}
?>