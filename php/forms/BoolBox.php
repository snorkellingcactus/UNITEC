<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormSelectBool.php';

	class BoolBox extends LabelBox
	{
		function __construct($parentForm , $name , $id , $labelText)
		{
			parent::__construct
			(
				$name,
				$id,
				$labelText,
				new FormSelectBool($parentForm , 'Si' , 'No')
			);
		}
	}
?>