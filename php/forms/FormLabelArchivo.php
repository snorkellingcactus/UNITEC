<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FileBox.php';

	class FormLabelArchivo extends FileBox
	{
		function __construct()
		{
			parent::__construct('Archivo' , 'archivo' , gettext('Archivo'));
		}
	}
?>