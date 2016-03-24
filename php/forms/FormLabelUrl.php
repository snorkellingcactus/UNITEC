<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FileBox.php';

	class FormLabelUrl extends TextBox
	{
		function __construct()
		{
			parent::__construct( 'Url' , 'url' , gettext('Url'));
		}
	}
?>