<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAddBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliOk extends FormCliAddBase
	{
		function __construct()
		{
			parent::__construct
			(
				FormActions::FORM_ITEM_TYPE_A ,
				gettext('0K') ,
				1
			);
		}
	}
?>