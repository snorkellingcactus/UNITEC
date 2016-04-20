<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEditBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliPublicar extends FormCliEditBase
	{
		function __construct()
		{
			parent::__construct(FormActions::FORM_ITEM_TYPE_A , gettext('Publicar'));
		}
	}
?>