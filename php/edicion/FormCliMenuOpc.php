<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmSec.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDelBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEdit.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';
	
	class FormCliMenuOpc extends FormCliAdmSec
	{
		function __construct($id , $num, $visible)
		{
			parent::__construct('accionesMenu' , $num , $id , $visible);

			$this->buttons->appendChild
			(
				new FormCliEdit(FormActions::FORM_ITEM_TYPE_A , 1)
			)->appendChild
			(
				new FormCliDelBase(FormActions::FORM_ITEM_TYPE_A)
			);
		}
	}
?>