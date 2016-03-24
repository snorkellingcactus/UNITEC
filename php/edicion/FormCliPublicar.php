<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEditBase.php';

	class FormCliPublicar extends FormCliEditBase
	{
		function __construct()
		{
			parent::__construct(gettext('Publicar'));
		}
	}
?>