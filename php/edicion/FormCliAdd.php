<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';

	class FormCliAdd extends FormCliAddBase
	{
		function __construct($form_item_type , $cMax)
		{
			parent::__construct
			(
				$form_item_type,
				ngettext('Nuevo' , 'Nuevo(s)' , $cMax) ,
				$cMax
			);
		}
	}
?>