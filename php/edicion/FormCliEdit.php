<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEditBase.php';

	class FormCliEdit extends FormCliEditBase
	{
		function __construct($form_item_type)
		{
			parent::__construct
			(
				$form_item_type ,
				gettext('Editar')
			);
		}
	}
?>