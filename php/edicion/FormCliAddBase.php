<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormSecBtn.php';

	class FormCliAddBase extends FormSecBtn
	{
		function __construct($name , $cMax)
		{
			parent::__construct
			(
				'nuevo' , $name , $cMax
			);
		}
	}
?>