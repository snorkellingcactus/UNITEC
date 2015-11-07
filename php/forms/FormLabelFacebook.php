<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelFacebook extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Facebook' , 'facebook' , gettext('Facebook'));
		}
	}
?>