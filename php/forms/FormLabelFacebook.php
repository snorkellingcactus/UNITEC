<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelFacebook extends TextBox
	{
		function __construct()
		{
			parent::__construct('Facebook' , 'facebook' , gettext('Facebook'));
		}
	}
?>