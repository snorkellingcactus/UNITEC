<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelAtajo extends TextBox
	{
		function __construct()
		{
			parent::__construct('Atajo' , 'atajo' , gettext('Atajo'));
			$this->input->setAttribute('maxlength','1');
		}
	}
?>