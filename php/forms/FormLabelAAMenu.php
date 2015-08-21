<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/BoolBox.php';

	class FormLabelAAlMenu extends BoolBox
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				$parentForm,
				'AgregarAlMenu',
				'agregarAlMenu',
				'Agregar al Menú'
			);
		}
	}
?>