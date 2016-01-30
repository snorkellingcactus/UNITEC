<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelAsunto extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Asunto' , 'asunto' , gettext('Asunto'));
		}
	}
?>