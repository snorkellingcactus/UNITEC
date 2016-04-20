<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDelBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdd.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEdit.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/FormActions.php';

	class FormCliLab extends FormCliAdmBase
	{
		function __construct($id)
		{
			parent::__construct('accionesLab');

			$add=new FormCliAdd(FormActions::FORM_ITEM_TYPE_A , 1);
			$del=new FormCliDelBase(FormActions::FORM_ITEM_TYPE_A);
			$edit=new FormCliEdit(FormActions::FORM_ITEM_TYPE_A);

			$varConID=new VariablePost('conID' , $id);

			$add->addToAttribute('class' , 'semitrans');
			$del->addToAttribute('class' , 'semitrans');
			$edit->addToAttribute('class' , 'semitrans');

			$add->col=$del->col=$edit->col=['xs'=>4, 'sm'=>4, 'md'=>4, 'lg'=>4];
		
			$this->appendChild
			(
				$varConID
			)->buttons->appendChild($add)->appendChild($edit)->appendChild($del);
		}
	}
?>