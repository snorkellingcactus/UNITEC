<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormSecBtn.php';

	class FormCliDel extends FormSecBtn
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				$parentForm ,'elimina' ,gettext('Eliminar')
			);
		}
	}
?>