<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormSecBtn.php';

	class FormCliAdd extends FormSecBtn
	{
		function __construct($parentForm , $cMax)
		{
			parent::__construct
			(
				$parentForm , 'nuevo' ,ngettext('Nuevo' , 'Nuevo(s)' , $cMax)
			);
		}
	}
?>