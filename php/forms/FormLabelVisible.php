<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBool.php';

	class FormLabelVisible extends LabelBox
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				'Visible',
				'visible',
				'Visible',
				new FormSelectBool($parentForm,'Si','No')
			);
		}
	}
?>