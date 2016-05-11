<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelTags extends TextBox
	{
		function __construct()
		{
			parent::__construct
			(
				'Tags' ,
				'etiquetas' ,
				gettext('Etiquetas')
			);
		}


	}
?>