<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelAlt extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Alt' , 'alt' , 'Alt');
		}
	}
?>