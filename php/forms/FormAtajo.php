<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/TextBox.php';

	class FormAtajo extends TextBox
	{
		function __construct()
		{
			parent::__construct('Titulo' , 'titulo' , 'Titulo');
		}
	}
?>