<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelAsunto extends TextBox
	{
		function __construct()
		{
			parent::__construct('Asunto' , 'asunto' , gettext('Asunto'));
		}
	}
?>