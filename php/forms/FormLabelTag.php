<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelTag extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Tag' , 'tag' , gettext('Etiqueta'));
		}
	}
?>