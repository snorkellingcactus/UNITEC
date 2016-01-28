<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';

	class FormCliAdd extends FormCliAddBase
	{
		function __construct($parentForm , $cMax)
		{
			parent::__construct
			(
				$parentForm , ngettext('Nuevo' , 'Nuevo(s)' , $cMax) , $cMax
			);
		}
	}
?>