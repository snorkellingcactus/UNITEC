<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormSecBtn.php';

	class FormCliEdit extends FormSecBtn
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				$parentForm , 'edita' ,gettext('Editar')
			);
		}
	}
?>