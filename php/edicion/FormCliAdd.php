<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';

	class FormCliAdd extends FormCliAddBase
	{
		function __construct($cMax)
		{
			parent::__construct
			(
				ngettext('Nuevo' , 'Nuevo(s)' , $cMax) , $cMax
			);
		}
	}
?>