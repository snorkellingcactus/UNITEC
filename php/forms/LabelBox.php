<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBox.php';
	//Revisar. Está de figurita.	
	class LabelBox extends FormLabelBox
	{
		function __construct()
		{
			call_user_func_array
			(
				array('parent', '__construct'),
				func_get_args()
			);
		}
	}
?>