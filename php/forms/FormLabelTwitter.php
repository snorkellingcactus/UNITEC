<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelTwitter extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Twitter' , 'twitter' , gettext('Twitter'));
		}
	}
?>