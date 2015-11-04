<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelTags extends TextBox
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				$parentForm ,
				'Tags' ,
				'etiquetas' ,
				gettext('Etiquetas')
			);
		}
	}
?>