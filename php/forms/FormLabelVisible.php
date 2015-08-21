<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBool.php';

	class FormLabelVisible extends LabelBox
	{
		function __construct()
		{
			parent::__construct
			(
				'Visible',
				'visible',
				'Visible',
				new FormSelectBool('Si','No')
			);
		}
	}
?>