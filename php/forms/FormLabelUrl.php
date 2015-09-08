<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FileBox.php';

	class FormLabelUrl extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Url' , 'url' , 'Url');
		}
	}
?>