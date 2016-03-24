<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormSecBtn.php';

	class FormCliDel extends FormSecBtn
	{
		function __construct()
		{
			parent::__construct
			(
				'elimina' ,gettext('Eliminar')
			);
		}
	}
?>