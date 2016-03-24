<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBool.php';

	class FormLabelEnlace extends LabelBox
	{
		function __construct()
		{
			parent::__construct
			(
				'Enlace',
				'enlace',
				gettext('Es un enlace?'),
				new FormSelectBool(gettext('Si') , gettext('No'))
			);
		}
	}
?>