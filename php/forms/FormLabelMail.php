<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelMail extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Mail' , 'mail' , gettext('E-Mail'));
		}
	}
?>