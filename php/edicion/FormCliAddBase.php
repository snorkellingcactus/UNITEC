<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormSecBtn.php';

	class FormCliAddBase extends FormSecBtn
	{
		function __construct($parentForm , $name , $cMax)
		{
			parent::__construct
			(
				$parentForm , 'nuevo' , $name , $cMax
			);
		}
	}
?>