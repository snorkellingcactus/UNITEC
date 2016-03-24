<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormLabelTitulo extends TextBox
	{
		function __construct()
		{
			parent::__construct( 'Titulo' , 'titulo' , gettext('Titulo'));
		}
	}
?>