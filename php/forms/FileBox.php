<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/LabelBox.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/FormInput.php';

	class FileBox extends LabelBox
	{
		function __construct($name , $id , $labelText)
		{
			parent::__construct
			(
				$name,
				$id,
				$labelText,
				new FormInput('file')
			);
		}
	}
?>