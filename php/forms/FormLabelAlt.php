<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelAlt extends TextBox
	{
		function __construct()
		{
			parent::__construct('Alt' , 'alt' , gettext('Alt'));
		}
	}
?>