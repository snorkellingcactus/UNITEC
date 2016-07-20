<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';

	class FormLabelAbbr extends LabelBox
	{
		function __construct()
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBool.php';
			
			parent::__construct
			(
				'Abbr',
				'abbr',
				gettext('Abreviatura'),
				new FormSelectBool(gettext('Si'),gettext('No'))
			);
		}
	}
?>