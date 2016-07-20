<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';

	class FormLabelIcono extends LabelBox
	{
		function __construct()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBool.php';

			parent::__construct
			(
				'Icono',
				'icono',
				gettext('Icono'),
				new FormSelectBool( gettext('Si') , gettext('No') )
			);
		}
	}
?>