<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugarBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	
	class FormLabelModulo extends FormLabelLugarBase
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				'Modulo',
				'modulo',
				'Modulo',
				new FormSelect($parentForm)
			);
		}
	}
?>