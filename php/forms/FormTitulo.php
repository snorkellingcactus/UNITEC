<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormTitulo extends TextBox
	{
		function __construct()
		{
			parent::__construct('Titulo' , 'titulo' , 'Titulo');
		}
	}
?>