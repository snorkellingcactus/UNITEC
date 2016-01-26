<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormSecBtn.php';

	class FormCliEditBase extends FormSecBtn
	{
		function __construct($parentForm , $name)
		{
			parent::__construct
			(
				$parentForm ,
				'edita' ,
				$name
			);
		}
	}
?>