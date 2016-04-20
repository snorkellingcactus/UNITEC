<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormLabelBox.php';
	
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
		function setInput($input)
		{
			parent::setInput($input);
		}
	}
?>