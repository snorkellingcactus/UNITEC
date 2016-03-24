<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdmBase.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliDel.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliAdd.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/edicion/FormCliEdit.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/DOMTagContainer.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/php/forms/VariablePost.php';

	class FormCliLab extends FormCliAdmBase
	{
		function __construct($id)
		{
			parent::__construct('accionesLab');

			$add=new FormCliAdd(1);
			$del=new FormCliDel();
			$edit=new FormCliEdit();
			$varConID=new VariablePost('conID' , $id);

			$add->classList->add('semitrans');
			$del->classList->add('semitrans');
			$edit->classList->add('semitrans');

			$add->col=$del->col=$edit->col=['xs'=>4, 'sm'=>4, 'md'=>4, 'lg'=>4];
		
			$this->appendChild
			(
				$varConID
			)->buttons->appendChild($add)->appendChild($edit)->appendChild($del);
		}
	}
?>