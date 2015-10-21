<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FileBox.php';

	class FormLabelArchivo extends FileBox
	{
		function __construct($parentForm)
		{
			parent::__construct($parentForm , 'Archivo' , 'archivo' , gettext('Archivo'));
		}
	}
?>