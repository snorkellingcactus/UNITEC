<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmSec.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDelBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEdit.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliSec extends FormCliAdmSec
	{
		function __construct($id , $orden , $visible)
		{
			parent::__construct('accionesSec' , $orden , $id , $visible);

			$this->buttons->appendChild
			(
				new FormCliDelBase(FormActions::FORM_ITEM_TYPE_A)
			)->appendChild
			(
				new FormCliEdit(FormActions::FORM_ITEM_TYPE_A)
			);

			$this->addToAttribute('class' , 'FormCliSec');
		}
	}
?>