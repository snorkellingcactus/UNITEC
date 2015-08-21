<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelAtajo extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Atajo' , 'atajo' , 'Atajo');
		}
	}
?>