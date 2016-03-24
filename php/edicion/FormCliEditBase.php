<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormSecBtn.php';

	class FormCliEditBase extends FormSecBtn
	{
		function __construct($name)
		{
			parent::__construct
			(
				'edita' ,
				$name
			);
		}
	}
?>