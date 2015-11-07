<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBool.php';

	class FormLabelEnlace extends LabelBox
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				'Enlace',
				'enlace',
				gettext('Es un enlace?'),
				new FormSelectBool($parentForm,gettext('Si'),gettext('No'))
			);
		}
	}
?>