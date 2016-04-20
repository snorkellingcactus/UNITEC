<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmRight.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDelBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEdit.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliInc extends FormCliAdmSec
	{
		function __construct($id , $num , $visible)
		{
			parent::__construct('accionesSec' , $num , $id , $visible);

			$this->buttons->appendChild
			(
				new FormCliDelBase(FormActions::FORM_ITEM_TYPE_C)
			)->appendChild
			(
				new FormCliEdit(FormActions::FORM_ITEM_TYPE_C)
			);
		}
	}
?>