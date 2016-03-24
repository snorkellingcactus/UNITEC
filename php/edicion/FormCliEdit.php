<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEditBase.php';

	class FormCliEdit extends FormCliEditBase
	{
		function __construct()
		{
			parent::__construct
			(
				gettext('Editar')
			);
		}
	}
?>