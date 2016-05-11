<?php

	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelTag extends TextBox
	{
		function __construct()
		{
			parent::__construct( 'Tag' , 'tag' , gettext('Etiqueta'));
		}
	}

?>