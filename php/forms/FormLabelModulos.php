<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelLugarBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelect.php';
	
	class FormLabelModulos extends FormLabelLugarBase
	{
		function __construct()
		{
			parent::__construct
			(
				'Modulos',
				'modulos',
				'Modulos',
				new FormSelect()
			);
		}
	}
?>