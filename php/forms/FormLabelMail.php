<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelMail extends TextBox
	{
		function __construct()
		{
			parent::__construct( 'Mail' , 'mail' , gettext('E-Mail'));
		}
	}
?>