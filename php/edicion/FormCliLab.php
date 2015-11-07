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

			$add=new FormCliAdd($this , 1);
			$del=new FormCliDel($this);
			$edit=new FormCliEdit($this);
			$varConID=new VariablePost($this , 'conID' , $id);

			$add->classList->add('semitrans');
			$del->classList->add('semitrans');
			$edit->classList->add('semitrans');

			$add->col=$del->col=$edit->col=['xs'=>4, 'sm'=>4, 'md'=>4, 'lg'=>4];
		
			$this->appendChild
			(
				$varConID->setMulti(0)
			)->buttons->appendChild($add)->appendChild($edit)->appendChild($del);
		}
	}
?>