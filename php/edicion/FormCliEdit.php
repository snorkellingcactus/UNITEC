<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEditBase.php';

	class FormCliEdit extends FormCliEditBase
	{
		function __construct($parentForm)
		{
			parent::__construct
			(
				$parentForm ,
				gettext('Editar')
			);
		}
	}
?>